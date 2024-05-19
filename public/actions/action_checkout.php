<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/action_utils.php');
require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/transaction.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

try {
    $db = getDatabaseConnection();
    $response = [];


    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];

        if ($csrf === $session->getToken()) {
            $buyerId = $session->getId();

            if (intval($_POST['buyerId']) !== $buyerId) {
                throw new Exception('Unauthorized action.');
            }

            $firstName = $_POST['firstName'] ?? null;
            $lastName = $_POST['lastName'] ?? null;
            $address = $_POST['address'] ?? null;
            $postalCode = $_POST['postalCode'] ?? null;
            $paymentOption = $_POST['paymentOption'] ?? null;
            $totalPrice = $_POST['totalPrice'] ?? null;
            $shippingCost = floatval($_POST['shippingCost']) ?? null;
            $shippingAddress = $_POST['shippingAddress'] ?? null;
            $items = $_POST['items'] ?? [];

            if (!$firstName || !$lastName || !$address || !$postalCode || !$paymentOption || !$totalPrice || empty($items)) {
                throw new Exception('Invalid input data.');
            }

            $db->beginTransaction();

            $itemsBySeller = [];
            foreach ($items as $item) {
                $sellerId = Item::getSellerId($db, intval($item['itemId']));
                if (!isset($itemsBySeller[$sellerId])) {
                    $itemsBySeller[$sellerId] = [];
                }
                $itemsBySeller[$sellerId][] = $item;
            }
            foreach ($itemsBySeller as $sellerId => $sellerItems) {
                $sellerTotalPrice = 0;
                foreach ($sellerItems as $item) {
                    $sellerTotalPrice += Item::getPrice($db, intval($item['itemId']));
                }

                $transactionId = Transaction::create($db, $buyerId, $sellerId, $sellerTotalPrice, $shippingAddress);
                foreach ($sellerItems as $item) {
                    Transaction::addItemToTransaction($db, $transactionId, intval($item['itemId']));
                }
            }


            $db->commit();

            $response = ['success' => 'Transaction successfully added'];

        } else {
            $response = ['error' => 'Invalid CSRF token'];
        }
    } else {
        $response = ['error' => 'CSRF token missing'];
    }

    handleResponse($response, $session);

} catch (PDOException $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    $response = ['error' => 'A database error occurred. Please try again later.'];

    handleResponse($response, $session);

} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    $response = ['error' => 'An error occurred. Please try again later.'];

    handleResponse($response, $session);
}
?>
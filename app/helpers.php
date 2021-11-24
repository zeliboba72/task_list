<?php
use App\Models\User;

if (!function_exists('getHtmlForExecution')) {
    function getHtmlForExecution($execution) {
        switch ($execution) {
            case("low"):
                echo '<span class="text-success">' . 'Низкий' . '</span>';
                break;
            case("medium"):
                echo '<span class="text-warning">' . 'Средний' . '</span>';
                break;
            case("high"):
                echo '<span class="text-danger">' . 'Высокий' . '</span>';
                break;
        }
    }
}

if (!function_exists('getHtmlForStatus')) {
    function getHtmlForStatus($status) {
        switch ($status) {
            case("established"):
                echo 'К выполнению';
                break;
            case("performed"):
                echo '<span class="text-primary">' . 'Выполняется' . '</span>';
                break;
            case("completed"):
                echo '<span class="text-success">' . 'Выполнена' . '</span>';
                break;
            case("canceled"):
                echo '<span class="text-danger">' . 'Отменена' . '</span>';
                break;
        }
    }
}

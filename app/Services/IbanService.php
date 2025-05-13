<?php

namespace App\Services;

class IbanService
{
    /**
     * لیست کدهای بانک‌های ایران برای استخراج از شماره شبا
     */
    private static $bankCodes = [
        '055' => 'بانک اقتصاد نوین',
        '054' => 'بانک پارسیان',
        '057' => 'بانک پاسارگاد',
        '021' => 'پست بانک ایران',
        '018' => 'بانک تجارت',
        '051' => 'موسسه اعتباری توسعه',
        '020' => 'بانک توسعه صادرات',
        '013' => 'بانک رفاه کارگران',
        '056' => 'بانک سامان',
        '015' => 'بانک سپه',
        '058' => 'بانک سرمایه',
        '019' => 'بانک صادرات ایران',
        '011' => 'بانک صنعت و معدن',
        '053' => 'بانک کارآفرین',
        '016' => 'بانک کشاورزی',
        '010' => 'بانک مرکزی',
        '014' => 'بانک مسکن',
        '012' => 'بانک ملت',
        '017' => 'بانک ملی ایران',
        '022' => 'بانک توسعه تعاون',
        '059' => 'بانک خاورمیانه',
        '060' => 'بانک شهر',
        '061' => 'بانک گردشگری',
        '065' => 'بانک ایران زمین',
        '069' => 'بانک دی',
    ];

    /**
     * تشخیص نام بانک از شماره شبا
     */
    public static function detectBankName(string $iban): string
    {
        if (!preg_match('/^IR[0-9]{2}([0-9]{3})/', $iban, $matches)) {
            return 'نامشخص';
        }

        $bankCode = $matches[1];

        return self::$bankCodes[$bankCode] ?? 'نامشخص';
    }

    /**
     * اعتبارسنجی شماره شبا
     */
    public static function validateIban(string $iban): bool
    {
        $iban = str_replace(' ', '', $iban);

        if (!preg_match('/^IR[0-9]{24}$/', $iban)) {
            return false;
        }

        if (preg_match('/^IR[0-9]{2}([0-9]{3})/', $iban, $matches)) {
            $bankCode = $matches[1];
            return array_key_exists($bankCode, self::$bankCodes);
        }

        return false;
    }
}

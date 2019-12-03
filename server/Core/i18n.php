<?php
/**
 * @file i18n.php
 * Contains the `i18n` class.
 *
 * @version 1.3
 * @date    June 13, 2019 (20:25)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace Core;

/**
 * Supplies internalization (%i18n) functionality.
 */
class i18n
{
	/**
	 * The translation table.
	 */
	private static $table = array(
	// Error Messages
		'ERROR_UNEXPECTED' => array(
			'en' => 'An unexpected error has occurred.',
			'tr' => 'Beklenmeyen bir hata oluştu.',
		),
		'ERROR_ACCESS_DENIED' => array(
			'en' => 'Access denied.<br><br>Please reload the page and try again.',
			'tr' => 'Erişim engellendi.<br><br>Lütfen sayfayı yeniden yükleyip tekrar deneyin.',
		),
		'ERROR_INVALID_ACTION_NAME' => array(
			'en' => 'Invalid action name.',
			'tr' => 'Geçersiz eylem adı.',
		),
		'ERROR_DATA_COULD_NOT_BE_LOADED' => array(
			'en' => 'Data could not be loaded.',
			'tr' => 'Veri yüklenemedi.',
		),
		'ERROR_DATA_COULD_NOT_BE_SAVED' => array(
			'en' => 'Data could not be saved.',
			'tr' => 'Veri kaydedilemedi.',
		),
		'ERROR_DATA_COULD_NOT_BE_DELETED' => array(
			'en' => 'Data could not be deleted.',
			'tr' => 'Veri silinemedi.',
		),
		'ERROR_INVALID_USERNAME' => array(
			'en' => 'Invalid username.',
			'tr' => 'Geçersiz kullanıcı adı.',
		),
		'ERROR_USERNAME_ALREADY_EXISTS' => array(
			'en' => 'Username already exists.',
			'tr' => 'Kullanıcı adı zaten var.',
		),
		'ERROR_USERNAME_NOT_FOUND' => array(
			'en' => 'Username not found.',
			'tr' => 'Kullanıcı adı bulunamadı.',
		),
		'ERROR_INVALID_EMAIL' => array(
			'en' => 'Invalid email.',
			'tr' => 'Geçersiz e-posta.',
		),
		'ERROR_EMAIL_ALREADY_EXISTS' => array(
			'en' => 'Email already exists.',
			'tr' => 'E-posta zaten var.',
		),
		'ERROR_EMAIL_NOT_FOUND' => array(
			'en' => 'Email not found.',
			'tr' => 'E-posta bulunamadı.',
		),
		'ERROR_EMAIL_COULD_NOT_BE_SENT' => array(
			'en' => 'Email could not be sent.',
			'tr' => 'E-posta gönderilemedi.',
		),
		'ERROR_INVALID_PASSWORD_LENGTH' => array(
			'en' => 'Invalid password length.',
			'tr' => 'Şifre uzunluğu geçersiz.',
		),
		'ERROR_INCORRECT_PASSWORD' => array(
			'en' => 'Incorrect password.',
			'tr' => 'Yanlış şifre.',
		),
		'ERROR_INVALID_INPUT' => array(
			'en' => 'Invalid input.',
			'tr' => 'Geçersiz girdi.',
		),
		'ERROR_UNKNOWN_d' => array(
			'en' => 'Unknown error: %d',
			'tr' => 'Bilinmeyen hata: %d',
		),
	// General
		'HELLO_WORLD' => array(
			'en' => 'Hello, World!',
			'tr' => 'Merhaba, Dünya!',
		),
		'HELLO_s' => array(
			'en' => 'Hello, <b>%s</b>!',
			'tr' => 'Merhaba, <b>%s</b>!',
		),
		'COPYRIGHT' => array(
			'en' => 'Copyright &copy; %s %s. All rights reserved.',
			'tr' => 'Telif Hakkı &copy; %s %s. Tüm hakları saklıdır.',
		),
		'OK' => array(
			'en' => 'OK',
			'tr' => 'Tamam',
		),
		'CANCEL' => array(
			'en' => 'Cancel',
			'tr' => 'Vazgeç',
		),
		'SEND' => array(
			'en' => 'Send',
			'tr' => 'Gönder',
		),
		'SAVE' => array(
			'en' => 'Save',
			'tr' => 'Kaydet',
		),
		'UPDATE' => array(
			'en' => 'Update',
			'tr' => 'Güncelle',
		),
		'EMAIL' => array(
			'en' => 'Email',
			'tr' => 'E-posta',
		),
		'USERNAME' => array(
			'en' => 'Username',
			'tr' => 'Kullanıcı Adı',
		),
		'PASSWORD' => array(
			'en' => 'Password',
			'tr' => 'Şifre',
		),
		'SUCCESS' => array(
			'en' => 'Success',
			'tr' => 'Başarı',
		),
		'ERROR' => array(
			'en' => 'Error',
			'tr' => 'Hata',
		),
		'DELETE' => array(
			'en' => 'Delete',
			'tr' => 'Sil',
		),
		'ARE_YOU_SURE_YOU_WANT_TO_DELETE' => array(
			'en' => 'Are you sure you want to delete?',
			'tr' => 'Silmek istediğinizden emin misiniz?',
		),
		'PLEASE_WAIT' => array(
			'en' => 'Please wait...',
			'tr' => 'Lütfen bekleyin...',
		),
		'LOG_OUT' => array(
			'en' => 'Log Out',
			'tr' => 'Çıkış Yap',
		),
	// register.php
		'REGISTER' => array(
			'en' => 'Register',
			'tr' => 'Kayıt Ol',
		),
		'AN_ACCOUNT_ACTIVATION_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS' => array(
			'en' => 'An account activation link has been sent to your email address.<br><br>Please don\'t forget to check the "Junk" folder of your mailbox.',
			'tr' => 'Hesap etkinleştirme bağlantısı e-posta adresinize gönderildi.<br><br>Lütfen posta kutunuzun "Junk" klasörünü kontrol etmeyi unutmayın.',
		),
	// login.php
		'LOG_IN' => array(
			'en' => 'Log In',
			'tr' => 'Giriş Yap',
		),
	// activate-account.php
		'ACTIVATE_ACCOUNT' => array(
			'en' => 'Activate Account',
			'tr' => 'Hesabı Etkinleştir',
		),
		'HELLO_s_YOUR_ACCOUNT_IS_BEING_ACTIVATED' => array(
			'en' => 'Hello <b>%s</b>! Your account is being activated...',
			'tr' => 'Merhaba <b>%s</b>! Hesabınız etkinleştiriliyor...',
		),
	// forgot-password.php
		'FORGOT_PASSWORD' => array(
			'en' => 'Forgot Password',
			'tr' => 'Şifremi Unuttum',
		),
		'PLEASE_ENTER_YOUR_EMAIL_ADDRESS_WE_WILL_SEND_YOU_A_LINK_TO_RESET_YOUR_PASSWORD' => array(
			'en' => 'Please enter your email address. We will send you a link to reset your password.',
			'tr' => 'Lütfen e-posta adresinizi girin. Şifrenizi sıfırlamanız için size bir bağlantı göndereceğiz.',
		),
		'A_PASSWORD_RESET_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS' => array(
			'en' => 'A password reset link has been sent to your email address.<br><br>Please don\'t forget to check the "Junk" folder of your mailbox.',
			'tr' => 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.<br><br>Lütfen posta kutunuzun "Junk" klasörünü kontrol etmeyi unutmayın.',
		),
	// reset-password.php
		'RESET_PASSWORD' => array(
			'en' => 'Reset Password',
			'tr' => 'Şifreyi Sıfırla',
		),
		'HELLO_s_PLEASE_ENTER_YOUR_NEW_PASSWORD' => array(
			'en' => 'Hello <b>%s</b>. Please enter your new password.',
			'tr' => 'Merhaba <b>%s</b>. Lütfen yeni şifrenizi girin.',
		),
	// settings.php
		'SETTINGS' => array(
			'en' => 'Settings',
			'tr' => 'Ayarlar',
		),
		'CURRENT' => array(
			'en' => 'Current',
			'tr' => 'Mevcut',
		),
		'NEW' => array(
			'en' => 'New',
			'tr' => 'Yeni',
		),
		'PASSWORD_UPDATED' => array(
			'en' => 'Password updated.',
			'tr' => 'Şifre güncellendi.',
		),
	);

	/**
	 * Gets the translated string associated with the specified "i18n" identifier.
	 *
	 * @param string $id Identifier of a translated string.
	 * @param ... (optional) Variable argument list for formatting the
	 * translated string.
	 * @return If the method succeeds, the return value is a translated string
	 * in the current language.
	 * @return If the method fails because the identifier is not defined, or a
	 * translation was not found, the return value is an empty string.
	 */
	public static function Get($id/*, ...*/)
	{
		// If the id does not exist, return empty string.
		if (!array_key_exists($id, self::$table)) {
			if (Config::LOG)
				Log::Error(sprintf('Undefined i18n identifier: %s', $id));
			return '';
		}
		// Obtain the translations sub-array associated with the id.
		$translations = self::$table[$id];
		// If a translation does not exist, return empty string.
		if (!array_key_exists(Config::LANGUAGE, $translations)) {
			if (Config::LOG)
				Log::Error(sprintf('Translation in `%s` not found for i18n identifier: %s', Config::LANGUAGE, $id));
			return '';
		}
		// Obtain the translated value.
		$value = $translations[Config::LANGUAGE];
		// Support variable argument list for formatting: If the `Get` method
		// is called with extra parameters, substitude format specifiers in the
		// string (e.g. %s, %d) with these parameters.
		$args = func_get_args();
		if (count($args) > 1) {
			array_shift($args); // remove the first item which equals to `$id`.
			$value = vsprintf($value, $args);
		}
		return $value;
	}
}
?>

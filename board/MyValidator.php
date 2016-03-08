<?php
require_once 'DbManager.php';

class MyValidator {
	public $errorMsg;

	public function __construct() {
		$errorMsg = array();
		$this->checkEncoding($_GET);
		$this->checkEncoding($_POST);
		$this->checkEncoding($_COOKIE);
		$this->checkNull($_GET);
		$this->checkNull($_POST);
		$this->checkNull($_COOKIE);
	}

	private function checkEncoding(array $data) {
		foreach($data as $key => $value) {
			if (!mb_check_encoding($value)) {
				$this->errorMsg[] = "{$key}は不正な文字コードです。";
			}
		}
	}

	private function checkNull(array $data) {
		foreach($data as $key => $value) {
			if (preg_match('/\0/', $value)) {
				$this->errorMsg[] = "{$key}は不正な文字を含んでいます。";
			}
		}
	}

	public function requiredCheck($value, $name) {
		if (trim($value) === '') {
			$this->errorMsg[] = "{$name}は必須入力です。";
		}
	}

	public function lengthCheck($value, $name, $len) {
		if (trim($value) !== '') {
			if (mb_strlen($value) > $len) {
				$this->errorMsg[] = "{$name}は{$len}文字以内で入力してください。";
			}
		}
	}

	public function intTypeCheck($value, $name) {
		if (trim($value) !== '') {
			if (!ctype_digit($value)) {
				$this->errorMsg[] = "{$name}は数値で指定してください。";
			}
		}
	}

	public function rangeCheck($value, $name, $max, $min) {
		if (trim($value) !== '') {
			if ($value > $max || $value < $min) {
				$this->errorMsg[] = "{$name}は{$min}～{$max}で指定してください。";
			}
		}
	}

	public function dateTypeCheck($value, $name) {
		if (trim($value) !== '') {
			$res = preg_split('|([/\-])|', $value);
			if (count($res) !== 3 || !@checkdate($res[1], $res[2], $res[0])) {
				$this->errorMsg[] = "{$name}は日付形式で入力してください。";
			}
		}
	}

	public function regexCheck($value, $name, $pattern) {
		if (trim($value) !== '') {
			if (!preg_match($pattern, $value)) {
				$this->errorMsg[] = "{$name}は正しい形式で入力してください。";
			}
		}
	}

	public function inArrayCheck($value, $name, $opts) {
		if (trim($value) !== '') {
			if (!in_array($value, $opts)) {
				$tmp = implode(',', $opts);
				$this->errorMsg[] = "{$name}は{$tmp}の中から選択してください。";
			}
		}
	}

	public function duplicateCheck($value, $name, $sql) {
		try {
			$db = getDb();
			$stt = $db->prepare($sql);
			$stt->bindValue(':value', $value);
			$stt->execute();
			if (($row = $stt->fetch()) !== FALSE) {
				$this->errorMsg[] = "{$name}は重複しています。";
			}
		} catch(PDOException $e) {
			$this->errorMsg[] = $e->getMessage();
		}
	}

	public function isErrorMsgExist() {
		if (count($this->errorMsg) <= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getErrorMsg() {
		return $this->errorMsg;
	}
}

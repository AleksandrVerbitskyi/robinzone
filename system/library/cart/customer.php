<?php
namespace Cart;
class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $customer_group_id;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $address_id;

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['customer_id'])) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->firstname = $customer_query->row['firstname'];
				$this->lastname = $customer_query->row['lastname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($email, $password, $override = false) {
		if ($override) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];

			$this->customer_id = $customer_query->row['customer_id'];
			$this->firstname = $customer_query->row['firstname'];
			$this->lastname = $customer_query->row['lastname'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->address_id = $customer_query->row['address_id'];

			$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['customer_id']);

        $this->clearRememberMe($this->customer_id);

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->customer_group_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

    public function getFullName() {
	    $fullname = $this->lastname != '' ?  $this->lastname . ' ' . $this->firstname : $this->firstname;
        return $fullname;
    }

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getFax() {
		return $this->fax;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}

	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}

    // create auth token table for remember me functionality
    private function createAuthTokenTable() {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'auth_tokens` (';
        $sql .= '`auth_token_id` integer(11) UNSIGNED NOT NULL AUTO_INCREMENT,';
        $sql .= '`selector` char(12),';
        $sql .= '`token` char(64),';
        $sql .= '`user_id` integer(11) not null,';
        $sql .= '`expires` varchar(255),';
        $sql .= 'PRIMARY KEY (`auth_token_id`));';
        $this->db->query($sql);
    }

    public function setRememberMe($user_id) {
	    $selector = $this->generateToken(5);
	    $token = $this->generateToken();
	    $expires = time() + 60*60*24*30;
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "auth_tokens` SET
	    selector = '" . $selector . "',
	    token = '" . md5($this->db->escape($token)) . "',
	    user_id = " . (int)$user_id . ",
	    expires = '" . $expires . "';");
        setcookie('SELECTOR', $selector, $expires, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
        setcookie('TOKEN', $token, $expires, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
    }

    public function clearRememberMe($user_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "auth_tokens` WHERE user_id = " . (int)$user_id . ";");
        setcookie('SELECTOR', '', time() - 3600, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
        setcookie('TOKEN', '', time() - 3600, ini_get('session.cookie_path'), ini_get('session.cookie_domain'), ini_get('session.cookie_secure'), ini_get('session.cookie_httponly'));
    }

    public function checkRememberMe($selector, $token) {
        $selector = $this->db->escape($selector);
        $token = $this->db->escape($token);
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "auth_tokens` WHERE selector = '" . $selector . "' ");
        if ($query->num_rows) {
            if (md5($token) == $query->row['token']) {
                $user_id = $query->row['user_id'];
                $customer_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE customer_id = " . $user_id . " ");
                if ($customer_query->num_rows) {
                    $this->session->data['customer_id'] = $customer_query->row['customer_id'];

                    $this->customer_id = $customer_query->row['customer_id'];
                    $this->firstname = $customer_query->row['firstname'];
                    $this->lastname = $customer_query->row['lastname'];
                    $this->customer_group_id = $customer_query->row['customer_group_id'];
                    $this->email = $customer_query->row['email'];
                    $this->telephone = $customer_query->row['telephone'];
                    $this->fax = $customer_query->row['fax'];
                    $this->newsletter = $customer_query->row['newsletter'];
                    $this->address_id = $customer_query->row['address_id'];

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    private function generateToken($length = 20)
    {
        if (function_exists('random_bytes')) {
            return substr(bin2hex(random_bytes(26)), 0, 26);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return substr(bin2hex(openssl_random_pseudo_bytes(26)), 0, 26);
        } else {
            return substr(bin2hex(mcrypt_create_iv(26, MCRYPT_DEV_URANDOM)), 0, 26);
        }
    }
}

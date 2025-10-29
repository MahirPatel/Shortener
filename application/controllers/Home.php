<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index($shortCode = '')
	{
		$param = $this->input->get(null, TRUE);
		if(isset($param) && is_array($param) && count($param) > 0){
			reset($param);
			$query_param = key($param);
			echo $query_param;
			if($query_param != ''){
				$shortCode = $query_param;
			}
		}
		if ($shortCode != '') {
			
			$check_url = $this->verify($shortCode);
			if(isset($check_url) && is_array($check_url) && count($check_url) > 0){
				$this->update($check_url['id']);
				$redirection_url = $check_url['original_link'];
				redirect($redirection_url);
			}
			else{
				if($shortCode != ''){
					echo 'URL Not Found';	
				}
			}
		}else {
			$this->load->view('home');
		}
	}

	public function create(){
		$url = $this->input->post('url');
		$check_url = $this->check($url);
		$response_arr = [];
		if(isset($check_url) && is_array($check_url) && count($check_url) > 0){
			$response_arr = [
				'original_link' => $check_url['original_link'],
				'short_link' => base_url().$check_url['short_link'],
				'clicks' => $check_url['clicks'],
				'clicksfrom' => $check_url['clicksfrom']
			];
		}else{
			$hash_url = $this->hashing($url);
			$this->store($url,$hash_url);
			$response_arr = [
				'original_link' => $url,
				'short_link' => base_url().$hash_url,
				'clicks' => 0,
				'clicksfrom' => ''
			];
		}
		echo json_encode($response_arr); die;
	}

	public function check($url){
		$this->db->select('original_link,short_link,clicks,created,clicksfrom');
		$this->db->from('shortener_links');
		$this->db->where('original_link', $url);
		$check = $this->db->get()->row_array();
		return $check;
	}

	public function verify($hash_url){
		$this->db->select('id,original_link,short_link,clicks,created,clicksfrom');
		$this->db->from('shortener_links');
		$this->db->where('short_link', $hash_url);
		$check = $this->db->get()->row_array();
		return $check;
	}

	public function store($url,$hash_url){
		$data = [  
			'original_link' => $url,  
			'short_link' => $hash_url  
		];
		$this->db->insert('shortener_links',$data);  
	}

	public function update($id){
		$this->db->set('clicks', 'clicks+1', FALSE);
		$this->db->where('id', $id);
		$this->db->update('shortener_links');

		$current_referrer = $this->input->server('HTTP_REFERER') ? $this->input->server('HTTP_REFERER') : (isset($_SERVER['REDIRECT_HTTP_REFERER']) ? $_SERVER['REDIRECT_HTTP_REFERER'] : 'Direct');
		$current_platform = $this->getPlatform();

		$this->db->select('original_link,short_link,clicks,created,clicksfrom');
		$this->db->from('shortener_links');
		$this->db->where('id', $id);
		$check = $this->db->get()->row_array();
		if(isset($check) && is_array($check) && count($check) > 0){
			$clicks = (isset($check['clicks']) && $check['clicks'] > 0) ? $check['clicks'] : 0;
			$clicks = $clicks + 1;			
			$clicksfrom = $check['clicksfrom'];
			$clicksfromJson = [];
			$platformsArr = [];
			$referrerArr = [];
			$old_platform = [];
			$old_referrer = [];
			if(isset($clicksfrom) && $clicksfrom != ''){

				$clicksfrom = json_decode($clicksfrom,TRUE);
				if(isset($clicksfrom) && isset($clicksfrom['platform']) && $clicksfrom['platform'] != ''){
					$old_platform = $clicksfrom['platform'];
					if(isset($old_platform) && is_array($old_platform) && count($old_platform) > 0){
						$platform_found = false;
						foreach ($old_platform as $key => $value) {
							if(strtolower($key) == strtolower($current_platform)){
								$platform_found = true;
								$old_platform[$key] = $value+1;
							}
						}
						if($platform_found == false){
							$old_platform[$current_platform] = 1;
						}
					}else{
						$old_platform[$current_platform] = 1;
					}
				}else{
					$old_platform[$current_platform] = 1;
				}

				if(isset($clicksfrom) && isset($clicksfrom['referrer']) && $clicksfrom['referrer'] != ''){
					$old_referrer = $clicksfrom['referrer'];
					if(isset($old_referrer) && is_array($old_referrer) && count($old_referrer) > 0){
						$referrer_found = false;
						foreach ($old_referrer as $key => $value) {
							if(strtolower($key) == strtolower($current_referrer)){
								$referrer_found = true;
								$old_referrer[$key] = $value+1;
							}
						}
						if($referrer_found == false){
							$old_referrer[$current_referrer] = 1;
						}
					}else{
						$old_referrer[$current_referrer] = 1;
					}
				}else{
					$old_referrer[$current_referrer] = 1;
				}
				$clicksfromJson['platform'] = $old_platform;
				$clicksfromJson['referrer'] = $old_referrer;
			}else{
				$clicksfromJson['platform'] = [$current_platform => 1];
				$clicksfromJson['referrer'] = [$current_referrer => 1];
			}
			$clicksfromJson = json_encode($clicksfromJson);
			$this->db->set('clicksfrom', $clicksfromJson);
			$this->db->where('id', $id);
			$this->db->update('shortener_links');
		}

	}

	public function hashing($url){
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$length = 10;
		$shortURL = '';
		for ($i = 0; $i < $length; $i++) {
			$shortURL .= $characters[rand(0, strlen($characters) - 1)];
		}
		$verify_url = $this->verify($shortURL);
		if(isset($verify_url) && is_array($verify_url) && count($verify_url) > 0){
			for ($i = 0; $i < $length; $i++) {
				$shortURL .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $shortURL;
		}else{
			return $shortURL;
		}
	}

	public function download_qr_code(){
		$url = $this->input->get('url');
		$qr_code_url = 'https://qrcode.tec-it.com/API/QRCode?data='.urlencode($url).'&backcolor=%23ffffff&size=small&quietzone=1&errorcorrection=H';
    	$qr_code_image = file_get_contents($qr_code_url);
    	$file_name = 'qr_code.png';
	    header('Content-Type: image/png');
	    header('Content-Disposition: attachment; filename="' . $file_name . '"');
	    header('Content-Length: ' . strlen($qr_code_image));

    	echo $qr_code_image;
    	exit;
	}

	function getPlatform() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
	    if (stripos($userAgent, 'android') !== false) {
	        return 'Android';
	    }elseif (stripos($userAgent, 'iphone') !== false || stripos($userAgent, 'ipad') !== false || stripos($userAgent, 'ipod') !== false) {
	        return 'iOS';
	    }elseif (stripos($userAgent, 'windows') !== false) {
	        return 'Windows';
	    }elseif (stripos($userAgent, 'macintosh') !== false) {
	        return 'macOS';
	    }elseif (stripos($userAgent, 'linux') !== false) {
	        return 'Linux';
	    }else {
	        return 'Web/Desktop';
	    }
	}
}

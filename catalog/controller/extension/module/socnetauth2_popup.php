<?php
class ControllerExtensionModuleSocnetauth2popup extends Controller {
	private $data;
	
	public function index($setting) {
	
		$this->language->load('extension/module/socnetauth2');
		
		if ($this->customer->isLogged()) {
	  		return false;
    	}
		
		if( !$this->config->get('socnetauth2_status') ) return false;
		
		if( empty( $_COOKIE['show_socauth2_popup'] ) )
		{
			$this->data['show_socauth2_popup'] = 1;
		}
		else
		{
			$this->data['show_socauth2_popup'] = 0;
		}
		
		$this->data['socnetauth2_mobile_control'] = $this->config->get('socnetauth2_mobile_control');
		
		
      	$this->data['socnetauth2_vkontakte_status'] = $this->config->get('socnetauth2_vkontakte_status');
      	$this->data['socnetauth2_odnoklassniki_status'] = $this->config->get('socnetauth2_odnoklassniki_status');
      	$this->data['socnetauth2_facebook_status'] = $this->config->get('socnetauth2_facebook_status');
      	$this->data['socnetauth2_twitter_status'] = $this->config->get('socnetauth2_twitter_status');
      	$this->data['socnetauth2_gmail_status'] = $this->config->get('socnetauth2_gmail_status');
      	$this->data['socnetauth2_mailru_status'] = $this->config->get('socnetauth2_mailru_status');
		
		$socnetauth2_popup_label = $this->config->get('socnetauth2_popup_label');		
		
		if( !is_array($socnetauth2_popup_label) && 
				stristr($this->config->get('socnetauth2_popup_label'), '{' ) != false &&
				stristr($this->config->get('socnetauth2_popup_label'), '}' ) != false &&
				stristr($this->config->get('socnetauth2_popup_label'), ';' ) != false &&
				stristr($this->config->get('socnetauth2_popup_label'), ':' ) != false )
		{
			$socnetauth2_popup_label = unserialize($socnetauth2_popup_label);
		}
		
    	$this->data['heading_title1'] = $socnetauth2_popup_label[ $this->config->get('config_language_id') ];
		
		$services = array(
			"vkontakte" => "vk", 
			"odnoklassniki" => "od", 
			"facebook" 	=> "fb", 
			"twitter" 	=> "tw", 
			"gmail" 	=> "gm", 
			"mailru" 	=> "mr"
		);
		
		$list = array();
		foreach($services as $service_key=>$short)
		{
			if( $this->config->get('socnetauth2_'.$service_key.'_status') )
			{
				$list[$service_key] = $short;
			}
		}
		
		$this->data['services'] = $list;
		
		
      	//$this->data['heading_title1'] = $this->language->get('heading_title1');
      	//$this->data['heading_title2'] = $this->language->get('heading_title2');
      	$this->data['text_skip'] = $this->language->get('text_skip');
		
		return $this->load->view('extension/module/socnetauth2_popup', $this->data);
	
		
	}
}
?>
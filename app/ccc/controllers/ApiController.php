<?php

defined( 'PATH_ROOT' ) or die( 'Access Denied.' ) ;

/**
 * ApiController
 * @author  taozywu<wutao@bwstor.com.cn>
 * @date 2013/06/04
 */
class ApiController extends Ccc_Base_Controller
{

	/**
	 * 初始化
	 * @see Ccc_Base_Controller::init()
	 */
	public function init()
	{
		parent::init() ;
	}

	public function indexAction()
	{
		$this->_forward( "login" ) ;
	}

	// 验证LDAP登录
	public function checkldapAction()
	{
		// get the paramter.
		// check_act | check_user | check_pass
		// 先去mysql验证，如果验证通过，去ldap验证，
		$ldapAction = trim( $this->_getParam( "check_act" ) ) ;
		$ldapUser = trim( $this->_getParam( "check_user" ) ) ;
		$ldapPass = $this->_getParam( "check_pass" ) ;
		if( !isset( $ldapAction ) || empty( $ldapAction ) )
			return 0 ;
		$ldapUserStr = str_replace( "%" , $ldapUser , $this->_conf->ldap->user ) ;
		if( $action == "login" )
		{
			$ldap_conn = @ldap_connect( $this->_conf->ldap->host , $this->_conf->ldap->port ) ;
			$ret = @ldap_bind( $ldap_conn , $ldapUserStr , $ldapPass ) ;
			if( $ret )
			{
				return 1 ;
			}
			else
			{
				return 0 ;
			}
		}
	}

}
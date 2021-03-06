<?php

namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    protected $tableName = 't_user'; 


    /** 
     * 登录
     * @param array  $uinfo 用户信息
     * @return bool 操作结果
     */  
    public function login($uinfo){
        // 查找用户
        $user = $this->get_user_id($uinfo['openid']);
        if (count($user) == 0){
            // 创建
            return $this->create_user($uinfo);
        }else{
            // 更新
            return $this->update_user($user[0]['id'], $uinfo);
        }
    }

    /** 
     * 根据openid查找用户
     * @param array  $uinfo 用户信息
     * @return array 用户信息
     */  
    public function get_user_id($openid){
        // 查询数据
        $result = $this->where(array(
            'openid' => $openid, 
        ))->field('id')->select();
        return $result;
    }

	/** 
	 * 创建用户
     * @param array  $uinfo 用户信息
	 * @return bool 操作结果
	 */  
    private function create_user($uinfo){
    	$data = array (
            'openid' => $uinfo['openid'], 
            'nickname' => $uinfo['nickname'],
            'gender' => $uinfo['gender'],
            'city' => $uinfo['city'],
            'avatar_url' => $uinfo['avatar_url'],
        );
        
        // 插入数据
		$result = $this->add($data);
    	return $result != false;
    }

    /** 
     * 更新用户信息
     * @param array  $uinfo 用户信息
     * @return bool 操作结果
     */  
    private function update_user($uid, $uinfo){
        $data = array (
            'openid' => $uinfo['openid'],
            'nickname' => $uinfo['nickname'],
            'gender' => $uinfo['gender'],
            'city' => $uinfo['city'],
            'avatar_url' => $uinfo['avatar_url'],
        );
        
        // 更新数据
        $result = $this->where(array(
            'id' => $uid, 
        ))->save($data);
        return $result !== false;
    }
}
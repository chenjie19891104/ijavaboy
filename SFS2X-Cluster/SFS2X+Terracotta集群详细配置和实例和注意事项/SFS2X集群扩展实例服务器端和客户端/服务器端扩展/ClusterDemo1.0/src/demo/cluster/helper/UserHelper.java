package demo.cluster.helper;

import java.util.List;

import com.smartfoxserver.v2.entities.User;
import com.smartfoxserver.v2.entities.Zone;

public class UserHelper {
	
	/**
	 * 获取zone中的用户列表
	 * @param zone
	 * @return
	 */
	public static List<User> getRecipientList(Zone zone){
		
		return (List<User>)zone.getUserList();
	}

}

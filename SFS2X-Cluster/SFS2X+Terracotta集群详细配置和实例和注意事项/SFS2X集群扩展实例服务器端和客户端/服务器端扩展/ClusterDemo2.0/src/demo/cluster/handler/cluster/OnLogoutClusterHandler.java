package demo.cluster.handler.cluster;

import java.util.List;

import com.smartfoxserver.v2.entities.User;
import com.smartfoxserver.v2.entities.data.ISFSObject;
import com.smartfoxserver.v2.entities.data.SFSObject;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterClientEvent;
import demo.cluster.data.ClusterEvent;
import demo.cluster.data.ClusterUser;
import demo.cluster.helper.UserHelper;
import demo.cluster.utils.Logger;

/**
 * 收到用户登出的集群事件,让连接到本机的所有客户端知道该用户
 * 登出了
 * @author 陈杰
 *
 */
public class OnLogoutClusterHandler extends DefaultClusterHandler {

	public OnLogoutClusterHandler(ClusterExtention extension) {
		super(extension);
	}

	@Override
	public void handleClusterEvent(ClusterEvent event) throws Exception {
		
		ClusterUser user = (ClusterUser)event.getParam("user");
		
		List<User> recipients = UserHelper.getRecipientList(super.extension.getParentZone());
		
		ISFSObject response = new SFSObject();
		response.putUtfString("username", user.getName());
		
		Logger.info("收到一条集群消息:"+user.getName()+"离开了");
		
		super.extension.send(ClusterClientEvent.USER_LEFT, response, recipients);
		
	}

}

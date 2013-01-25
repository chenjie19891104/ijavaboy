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

public class OnLoginClusterHandler extends DefaultClusterHandler {
	
	public OnLoginClusterHandler(ClusterExtention extension){
		super(extension);
	}
	
	@Override
	public void handleClusterEvent(ClusterEvent event) throws Exception {
		
		//当一个用户加入的时候,向该节点上连接的所有客户端发送一条消息
		ClusterUser user = (ClusterUser)event.getParam("user");
		
		List<User> recipients = UserHelper.getRecipientList(super.extension.getParentZone());
		
		ISFSObject response = new SFSObject();
		response.putUtfString("username", user.getName());
		
		Logger.info("收到一条集群消息:"+user.getName()+"登陆了");
		
		super.extension.send(ClusterClientEvent.USER_JOINED, response, recipients);
		
	}

}

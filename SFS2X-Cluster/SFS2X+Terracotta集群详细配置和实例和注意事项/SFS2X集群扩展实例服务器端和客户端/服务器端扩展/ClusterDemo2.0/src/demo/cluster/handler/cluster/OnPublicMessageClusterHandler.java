package demo.cluster.handler.cluster;

import java.util.List;

import com.smartfoxserver.v2.entities.User;
import com.smartfoxserver.v2.entities.data.ISFSObject;
import com.smartfoxserver.v2.entities.data.SFSObject;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterClientEvent;
import demo.cluster.data.ClusterEvent;
import demo.cluster.data.ClusterEventParam;
import demo.cluster.data.ClusterUser;
import demo.cluster.helper.UserHelper;
import demo.cluster.utils.Logger;

/**
 * 收到一条公共消息的集群事件
 * @author 陈杰
 *
 */
public class OnPublicMessageClusterHandler extends DefaultClusterHandler {

	public OnPublicMessageClusterHandler(ClusterExtention extension) {
		super(extension);
	}

	@Override
	public void handleClusterEvent(ClusterEvent event) throws Exception {
		
		ClusterUser sender = (ClusterUser)event.getParam(ClusterEventParam.USER);
		String msg = (String)event.getParam(ClusterEventParam.MESSAGE);
		String roomName = (String)event.getParam(ClusterEventParam.ROOM_NAME);
		
		//向当前用户所在的房间中所有的用户发送
		List<User> recipients = UserHelper.getRecipientList(extension, roomName);
	
		ISFSObject response = new SFSObject();
		
		response.putUtfString("username", sender.getName());
		response.putUtfString("message", msg);
		
		Logger.reciever(String.format("%s 说 %s", sender.getName(), msg));
		
		super.extension.send(ClusterClientEvent.PUBLIC_MESSAGE, response, recipients);
		
	}
}

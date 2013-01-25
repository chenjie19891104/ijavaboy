package demo.cluster.handler.client;

import com.smartfoxserver.v2.core.ISFSEvent;
import com.smartfoxserver.v2.core.SFSEventParam;
import com.smartfoxserver.v2.entities.Room;
import com.smartfoxserver.v2.entities.User;
import com.smartfoxserver.v2.exceptions.SFSException;
import com.smartfoxserver.v2.extensions.BaseServerEventHandler;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterEvent;
import demo.cluster.data.ClusterEventParam;
import demo.cluster.data.ClusterUser;
import demo.cluster.data.DataStore;
import demo.cluster.utils.Logger;

/**
 * 处理公共消息的发送
 * @author 陈杰
 *
 */
public class OnPublicMessageHandler extends BaseServerEventHandler {

	@Override
	public void handleServerEvent(ISFSEvent event) throws SFSException {
		User sender = (User)event.getParameter(SFSEventParam.USER);
		String msg = (String)event.getParameter(SFSEventParam.MESSAGE);
		Room room = (Room)event.getParameter(SFSEventParam.ROOM);
		
		Logger.info(String.format("%s 说 %s", sender.getName(), msg));
		
		DataStore dataStore = DataStore.getInstance();
		
		ClusterEvent clusterEvent = new ClusterEvent(ClusterEvent.ON_PUBLIC_MESSAGE);
		ClusterUser user = new ClusterUser();
		user.setName(sender.getName());
		
		//Room currentRoom = RoomHelper.getRoomByName(getParentExtension(), "demo");
		
		Logger.info(String.format("当前的房间是:%s", room.getName()));
		
		clusterEvent.addParam(ClusterEventParam.ROOM_NAME, room.getName());
		clusterEvent.addParam(ClusterEventParam.USER, user);
		clusterEvent.addParam(ClusterEventParam.MESSAGE, msg);
		
		//发送集群事件
		String senderId = ((ClusterExtention)this.getParentExtension()).getNodeId();
		dataStore.dispatchClusterEventToAll(clusterEvent, senderId);
	}

}

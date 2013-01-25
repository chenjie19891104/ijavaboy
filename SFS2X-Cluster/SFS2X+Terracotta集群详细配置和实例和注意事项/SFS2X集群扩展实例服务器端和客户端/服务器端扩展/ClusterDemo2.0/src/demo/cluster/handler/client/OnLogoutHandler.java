package demo.cluster.handler.client;

import com.smartfoxserver.v2.core.ISFSEvent;
import com.smartfoxserver.v2.core.SFSEventParam;
import com.smartfoxserver.v2.entities.User;
import com.smartfoxserver.v2.exceptions.SFSException;
import com.smartfoxserver.v2.extensions.BaseServerEventHandler;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterEvent;
import demo.cluster.data.ClusterEventParam;
import demo.cluster.data.ClusterUser;
import demo.cluster.data.DataStore;

public class OnLogoutHandler extends BaseServerEventHandler{

	@Override
	public void handleServerEvent(ISFSEvent event) throws SFSException {
		
		User user = (User)event.getParameter(SFSEventParam.USER);
		
		//从集群中删除用户信息
		
		DataStore dataStore = DataStore.getInstance();
		
		dataStore.removeUserFromCluster(user.getName());
		
		//发送集群事件,通知
		ClusterEvent clusterEvent = new ClusterEvent(ClusterEvent.ON_USER_LOGOUT);
		ClusterUser clusterUser = new ClusterUser();
		clusterUser.setName(user.getName());
		
		clusterEvent.addParam(ClusterEventParam.USER, clusterUser);
		
		ClusterExtention extention = (ClusterExtention)this.getParentExtension();
		
		dataStore.dispatchClusterEventToAll(clusterEvent, extention.getNodeId());
		
		
	}

}

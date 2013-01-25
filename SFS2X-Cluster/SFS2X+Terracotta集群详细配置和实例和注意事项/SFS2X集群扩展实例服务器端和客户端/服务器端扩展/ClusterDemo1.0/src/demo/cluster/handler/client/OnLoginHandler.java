package demo.cluster.handler.client;

import java.util.List;

import com.smartfoxserver.v2.core.ISFSEvent;
import com.smartfoxserver.v2.core.SFSEventParam;
import com.smartfoxserver.v2.exceptions.SFSException;
import com.smartfoxserver.v2.extensions.BaseServerEventHandler;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterEvent;
import demo.cluster.data.ClusterUser;
import demo.cluster.data.DataStore;
import demo.cluster.utils.Logger;

public class OnLoginHandler extends BaseServerEventHandler {

	@Override
	public void handleServerEvent(ISFSEvent event) throws SFSException {
		
		String username = (String)event.getParameter(SFSEventParam.LOGIN_NAME);
		
		//加入到集群中去
		ClusterUser user = new ClusterUser();
		//user.setId(username);
		user.setName(username);
		
		Logger.info(String.format("%s 进入了", username));
		
		ClusterExtention extention = (ClusterExtention)this.getParentExtension();
		
		ClassLoader origLoader = Thread.currentThread().getContextClassLoader();
		ClassLoader extensionLoader = getClass().getClassLoader();
		
		Thread.currentThread().setContextClassLoader(extensionLoader);
		
		DataStore instance = DataStore.getInstance();
		
		Logger.info("实例化DataStore成功");
		
		//将用户加入到集群共享列表中,这样可以让每个集群服务器识别到
		try {
			//instance.getUsersInCluster().put(username, user);
			instance.getUsersInCluster().put(username, username);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		//向所有节点触发一个集群事件,同时传递用户对象
		ClusterEvent clusterEvent = new ClusterEvent(ClusterEvent.ON_USER_LOGIN);
		clusterEvent.addParam("user", user);
		
		Logger.info("登陆成功,开始发送集群事件");
		
		//向所有节点发送集群事件
		List<String> allNodes = instance.getAllClusteredNodes();
		
		instance.dispatchClusterEvent(clusterEvent, allNodes);
		
		Thread.currentThread().setContextClassLoader(origLoader);
		
	}

}

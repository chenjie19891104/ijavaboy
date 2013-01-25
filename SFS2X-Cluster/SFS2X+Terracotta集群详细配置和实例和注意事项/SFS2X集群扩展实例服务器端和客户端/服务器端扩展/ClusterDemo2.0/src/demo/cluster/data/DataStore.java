package demo.cluster.data;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.concurrent.BlockingQueue;
import java.util.concurrent.ConcurrentHashMap;

import demo.cluster.utils.Logger;



/**
 * 这个类是一个单例,存储所有需要暴露在集群中的数据
 * @author 陈杰
 *
 */
public class DataStore {
	
	//private Object lock = new Object();
	
	private Map<String, ClusterUser> usersInCluster;//集群中的用户
	//private Map<String, String> usersInCluster;
	
	private Map<String, BlockingQueue<ClusterEvent>> postOffice; //集群事件阻塞队列
	
	private static DataStore instance = new DataStore();
	
	private DataStore(){
		
		usersInCluster = new ConcurrentHashMap<String, ClusterUser>();
		//usersInCluster = new ConcurrentHashMap<String, String>();
		
		postOffice = new ConcurrentHashMap<String, BlockingQueue<ClusterEvent>>();
		
	}
	
	public static DataStore getInstance(){
		
		return instance;
	}
	
	/**
	 * 向recipientNode指定的node触发event事件
	 * @param event
	 * @param recipientNode
	 */
	public void dispatchClusterEvent(ClusterEvent event, String recipientNode){
		BlockingQueue<ClusterEvent> mailBox = instance.postOffice.get(recipientNode);
		
		if(mailBox != null && event != null){
			mailBox.offer(event); //将event事件推入该节点对应的BlockingQueue中
			
			Logger.info("dispatch a new event into blocking queue");
			
		}else{
			Logger.err("无法发布事件!Node:"+recipientNode+",Event:"+event.toString());
		}
	}

	/**
	 * 向所有指定的节点广播事件
	 * @param event
	 * @param recipientNodes
	 */
	public void dispatchClusterEvent(ClusterEvent event, List<String> recipientNodes){
		if(recipientNodes != null){
			for(String node : recipientNodes){
				this.dispatchClusterEvent(event, node);
			}
		}else{
			Logger.err("没有指定任何接收节点");
		}
	}
	
	/**
	 * 向集群中所有节点发送事件,除了自己
	 * @param event
	 */
	public void dispatchClusterEventToAll(ClusterEvent event, String senderId){
		
		this.dispatchClusterEvent(event, getAllClusteredNodes(senderId));
	}
	
	/**
	 * 返回所有集群中的节点的NodeId,除去senderId(发送者自己)
	 * @return
	 */
	public List<String> getAllClusteredNodes(String senderId){
		Iterator<String> iter = this.getPostOffice().keySet().iterator();
		List<String> nodeIds = new ArrayList<String>();
		
		while(iter.hasNext()){
			
			String node = iter.next();
			
			if(node.equalsIgnoreCase(senderId)){
				//排除发送者
				continue;
			}
			
			nodeIds.add(node);
			Logger.info("节点："+node);
		}
		
		return nodeIds;
	}
	
	public void addUserToCluster(String key, ClusterUser user){
		try {
			this.getUsersInCluster().put(key, user);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	public void removeUserFromCluster(String key){
		try {
			this.getUsersInCluster().remove(key);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}


	public Map<String, ClusterUser> getUsersInCluster() {
		return usersInCluster;
	}

	public void setUsersInCluster(Map<String, ClusterUser> usersInCluster) {
		this.usersInCluster = usersInCluster;
	}

	public Map<String, BlockingQueue<ClusterEvent>> getPostOffice() {
		return postOffice;
	}

	public void setPostOffice(Map<String, BlockingQueue<ClusterEvent>> postOffice) {
		this.postOffice = postOffice;
	}
	
	

}

package demo.cluster;

import java.util.concurrent.BlockingQueue;
import java.util.concurrent.Executor;
import java.util.concurrent.Executors;
import java.util.concurrent.LinkedBlockingQueue;

import com.smartfoxserver.v2.core.SFSEventType;
import com.smartfoxserver.v2.extensions.SFSExtension;

import demo.cluster.data.ClusterEvent;
import demo.cluster.data.DataStore;
import demo.cluster.handler.ClusterEventHandler;
import demo.cluster.handler.client.OnLoginHandler;
import demo.cluster.handler.cluster.OnLoginClusterHandler;
import demo.cluster.utils.ClusterUtils;
import demo.cluster.utils.Logger;

/**
 * Terracotta+sfs集群demo
 * @author 陈杰
 *
 */
public class ClusterExtention extends SFSExtension {
	
	public static final int WORKER_COUNT = 4; //在一个节点上负责处理集群事件的线程池中线程的个数
	
	private String nodeId;
	private BlockingQueue<ClusterEvent> queue;
	
	private DataStore dataStore;
	
	private Executor executor; //调用线程池中的线程完成eventHandler操作
	
	private ClusterEventHandler clusterEventHandler; //处理事件队列中的事件

	@Override
	public void init() {
		
		dataStore = DataStore.getInstance();
		
		
		Logger.info("初始化ClusterExtention,实例化dataStore...");

		nodeId = ClusterUtils.generateNodeId();
		
		if(nodeId != null){
			Logger.info(String.format("the nodeId is %s", nodeId));
			
			queue = new LinkedBlockingQueue<ClusterEvent>();
			
			/**
			 * 由于使用terracotta完成数据的共享,这里只需要初始化本节点的BlockingQueue就可以了
			 * 在另一个节点上部署相同的扩展的时候,生成的nodeId不同,但是postOffice是在整个集群范围内共享
			 * 的,所以这里需要注意下
			 */
			dataStore.getPostOffice().put(nodeId, queue);
			
			//初始化事件处理器
			clusterEventHandler = new ClusterEventHandler(queue); 
			
			registSystemEventHandlers();
			
			//初始化各种事件的Handler
			registClusterEventHandlers();
			
			executor = Executors.newFixedThreadPool(WORKER_COUNT); //创建固定数目的线程的线程池
			
			//启动所有线程
			for(int i=0; i<WORKER_COUNT; i++){
				executor.execute(clusterEventHandler);
			}
			
			this.addEventHandler(SFSEventType.USER_LOGIN, OnLoginHandler.class);
			
		}else{
			
			throw new RuntimeException("生成节点唯一标识ID失败,请检查SFS2X目录下是否正确配置了cluster-server.properties");
		}
		
		
	}
	
//	public void setClassLoader(){
//		ClassLoader loader = ClusterExtention.class.getClassLoader().getSystemClassLoader();
//		
//		Logger.info("The class loader is:"+loader.getClass().getName());
//	}
	
//	private String generateNodeId(){
//		InputStream in = getClass().getClassLoader().getResourceAsStream("cluster-server.properties");
//		
//		Map<String, String> config = PropertiesUtils.read(in);
//		
//		String ip = config.get("ip");
//		String port = config.get("port");
//		
//		return ClusterUtils.generateNodeId(ip, port);
//	}

	/**
	 * 初始化系统事件
	 */
	private void registSystemEventHandlers() {
		
		this.addEventHandler(SFSEventType.USER_LOGIN, OnLoginHandler.class);
		
	}

	/**
	 * 初始化集群事件处理器
	 */
	private void registClusterEventHandlers() {
		
		clusterEventHandler.addClusterEventHandler(ClusterEvent.ON_USER_LOGIN, new OnLoginClusterHandler(this));
		
	}

	public DataStore getDataStore() {
		return dataStore;
	}

	public void setDataStore(DataStore dataStore) {
		this.dataStore = dataStore;
	}
	
	

}

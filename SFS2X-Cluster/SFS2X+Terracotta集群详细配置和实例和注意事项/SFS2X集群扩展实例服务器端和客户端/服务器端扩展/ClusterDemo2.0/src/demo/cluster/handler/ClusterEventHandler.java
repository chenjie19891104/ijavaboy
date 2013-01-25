package demo.cluster.handler;

import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.BlockingQueue;

import demo.cluster.data.ClusterEvent;

/**
 * 每个节点上运行的工作线程,负责从该节点对应的BlockingQueue中提取事件,并调用相应的事件处理器进行处理
 * @author 陈杰
 *
 */
public class ClusterEventHandler implements Runnable{
	
	private boolean running = false;

	private BlockingQueue<ClusterEvent> eventQueue;
	
	private Map<String, IClusterEventHandler> eventHandlers; //事件的处理器
	
	public ClusterEventHandler(BlockingQueue<ClusterEvent> queue){
		this.eventQueue = queue;
		this.eventHandlers = new HashMap<String, IClusterEventHandler>();
	}
	
	public void run(){
		running = true;
		
		while(running){
			//处理
			try {
				ClusterEvent event = eventQueue.take(); //从队列中取出一个事件
				
				System.out.println("从事件队列中取出一个新事件");
				handleClusterEvent(event);
			} catch (InterruptedException e) {
				e.printStackTrace();
				running = false;
			}
		}
	}

	/**
	 * 处理触发的事件
	 * @param event
	 */
	private void handleClusterEvent(ClusterEvent event) {
		
		IClusterEventHandler handler = eventHandlers.get(event.getEventName());
		
		if(handler != null){
			try {
				handler.handleClusterEvent(event);
			} catch (Exception e) {

				e.printStackTrace();
			}
		}
		
	}
	
	/**
	 * 增加一个新的集群事件处理器
	 * @param eventName
	 * @param handler
	 */
	public void addClusterEventHandler(String eventName, IClusterEventHandler handler){
		
		this.eventHandlers.put(eventName, handler);
		
	}
	
}

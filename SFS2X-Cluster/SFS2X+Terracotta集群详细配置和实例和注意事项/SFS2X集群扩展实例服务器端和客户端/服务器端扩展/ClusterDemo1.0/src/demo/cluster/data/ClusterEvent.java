package demo.cluster.data;

import java.util.HashMap;
import java.util.Map;

/**
 * 集群事件类型,用于在节点之间通信,从而实现各个节点之间,各个节点和其对应的客户端信息的同步
 * @author 陈杰
 *
 */
public class ClusterEvent {
	
	public static final String ON_USER_LOGIN = "onUserLogin";
	
	private String eventName;
	
	private Map<String, Object> params;
	
	public ClusterEvent(String eventName){
		this.eventName = eventName;
		params = new HashMap<String, Object>();
	}
	
	public void addParam(String key, Object value){
		
		this.params.put(key, value);
	}
	
	public Object getParam(String key){
		
		return this.params.get(key);
	}

	public String getEventName() {
		return eventName;
	}

	public void setEventName(String eventName) {
		this.eventName = eventName;
	}

	public Map<String, Object> getParams() {
		return params;
	}

	public void setParams(Map<String, Object> params) {
		this.params = params;
	}
	
	public String toString(){
		
		return String.format("[name:%s,params:%s]", eventName, params);
	}
	
}

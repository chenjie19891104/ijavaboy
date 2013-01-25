package demo.cluster.data;

/**
 * 集群事件参数类型
 * @author 陈杰
 *
 */
public enum ClusterEventParam {
	
	USER("user"),
	ROOM("room"),
	ROOM_NAME("roomName"),
	MESSAGE("message");
	
	private String value;
	
	
	ClusterEventParam(String value) {
		
		this.value = value;
	}
	
	public String getValue(){
		
		return this.value;
	}

}

package demo.cluster.data;

import java.util.Map;

/**
 * 共享给集群的user对象
 * @author 陈杰
 *
 */
public class ClusterUser {
	
	private String nodeId;
	
	private String name;
	
	private int localUID;
	
	private Map<String, Object> properties;

	public String getNodeId() {
		return nodeId;
	}

	public void setNodeId(String nodeId) {
		this.nodeId = nodeId;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getLocalUID() {
		return localUID;
	}

	public void setLocalUID(int localUID) {
		this.localUID = localUID;
	}

	public Map<String, Object> getProperties() {
		return properties;
	}

	public void setProperties(Map<String, Object> properties) {
		this.properties = properties;
	}


	
	
}

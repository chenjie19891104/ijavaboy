package demo.sfs2x.client;

/**
 * SFS节点信息
 * @author 陈杰
 *
 */
public class SFSNode {
	
	private String nodeIp;
	private int nodePort;
	private int currentUsers;
	private int maxUsers;
	
	public String getNodeIp() {
		return nodeIp;
	}
	public void setNodeIp(String nodeIp) {
		this.nodeIp = nodeIp;
	}
	public int getNodePort() {
		return nodePort;
	}
	public void setNodePort(int nodePort) {
		this.nodePort = nodePort;
	}
	public int getCurrentUsers() {
		return currentUsers;
	}
	public void setCurrentUsers(int currentUsers) {
		this.currentUsers = currentUsers;
	}
	public int getMaxUsers() {
		return maxUsers;
	}
	public void setMaxUsers(int maxUsers) {
		this.maxUsers = maxUsers;
	}
	
	

}

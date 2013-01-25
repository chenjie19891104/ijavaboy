package demo.cluster.handler;

import demo.cluster.data.ClusterEvent;

/**
 * 所有集群事件处理器的公共接口
 * @author 陈杰
 *
 */
public interface IClusterEventHandler {
	
	public void handleClusterEvent(ClusterEvent event) throws Exception;

}

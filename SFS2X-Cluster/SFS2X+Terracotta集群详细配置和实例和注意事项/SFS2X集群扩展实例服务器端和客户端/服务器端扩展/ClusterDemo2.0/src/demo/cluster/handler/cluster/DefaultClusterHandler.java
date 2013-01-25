package demo.cluster.handler.cluster;

import demo.cluster.ClusterExtention;
import demo.cluster.data.ClusterEvent;
import demo.cluster.handler.IClusterEventHandler;

/**
 * 默认的ClusterHandler
 * @author 陈杰
 *
 */
public class DefaultClusterHandler implements IClusterEventHandler {
	
	protected ClusterExtention extension;
	
	public DefaultClusterHandler(ClusterExtention extension){
		this.extension = extension;
	}

	@Override
	public void handleClusterEvent(ClusterEvent event) throws Exception {

		//Do nothing, sub classes will implement it 
	}

}

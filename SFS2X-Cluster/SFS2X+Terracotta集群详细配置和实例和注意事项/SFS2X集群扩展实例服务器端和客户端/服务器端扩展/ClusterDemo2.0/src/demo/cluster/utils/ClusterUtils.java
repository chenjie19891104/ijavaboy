package demo.cluster.utils;

import java.io.InputStream;
import java.net.Inet4Address;
import java.net.InetAddress;
import java.net.UnknownHostException;
import java.util.Map;

public class ClusterUtils {
	
	private static final String SERVER_CONFIG_NAME = "cluster-server.properties";
	
	private static final String DEFULT_PORT = "9933";
	
	/**
	 * 根据本节点IP和运行smartfox的端口生成一个NodeID
	 * 
	 * NodeID的形式：192.168.168.41:9933
	 * @return
	 */
	private static String generateNodeId(String ip, String port){
		
		return String.format("%s:%s", ip, port);
	}
	
	/**
	 * 读取SFS2X目录下的cluster-server.properties配置文件,如果没有配置,则采用默认的
	 * @return
	 */
	public static String generateNodeId(){
		InputStream in = ClassLoader.getSystemClassLoader().getResourceAsStream(SERVER_CONFIG_NAME);
		if(in == null){
			//说明没有配置服务器的ip和端口,则采用默认的
			return ClusterUtils.generateDefalutNodeId();
			
		}else{
			//否则,说明读取到了
			
			Logger.info("使用cluster-server.properties文件中的配置生成节点的唯一标识");
			
			Map<String, String> config = PropertiesUtils.read(in);
			
			String ip = config.get("ip");
			String port = config.get("port");
			
			if(ip != null && port != null){
				return ClusterUtils.generateNodeId(ip, port);
			}else{
				return ClusterUtils.generateDefalutNodeId();
			}
			
		}
	}

	/**
	 * 默认的IP和端口
	 * @return
	 */
	private static String generateDefalutNodeId() {
		
		Logger.warn("在SFS2X目录下没有找到cluster-server.properties配置文件或者该配置文件格式不正确,将采用默认的配置");
		
		try {
			InetAddress addr = Inet4Address.getLocalHost();
			if(addr != null){
				String ip = addr.getHostAddress();
				
				Logger.info("采用了默认的IP:"+ip+";默认的端口:"+DEFULT_PORT);
				
				return ClusterUtils.generateNodeId(ip, DEFULT_PORT);
			}
		} catch (UnknownHostException e) {
			
			e.printStackTrace();
		}
		
		return null;
	}

}

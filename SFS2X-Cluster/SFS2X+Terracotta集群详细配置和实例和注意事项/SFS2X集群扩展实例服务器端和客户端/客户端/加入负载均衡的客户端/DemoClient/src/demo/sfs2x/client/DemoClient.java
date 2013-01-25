package demo.sfs2x.client;

import java.util.List;

import org.json.JSONException;

import com.smartfoxserver.v2.entities.data.ISFSObject;
import com.smartfoxserver.v2.entities.data.SFSObject;
import com.smartfoxserver.v2.exceptions.SFSException;

import sfs2x.client.SmartFox;
import sfs2x.client.core.BaseEvent;
import sfs2x.client.core.IEventListener;
import sfs2x.client.core.SFSEvent;
import sfs2x.client.requests.LoginRequest;

/**
 * 演示集群的SFS2X的客户端
 * 
 * 连接到SFS2X实例之前首先需要向http://ekarma.cn:8080/ekarmaPHP/phpinfo.php访问,
 * 查询当前所有SFS2X节点及其运行负载信息
 * 然后选择一个负载最小的节点并加入
 * @author 陈杰
 *
 */
public class DemoClient implements IEventListener{
	
	public static final String QUERY_IP = "http://ekarma.cn:8080/ekarmaPHP/phpinfo.php";
	
	private SmartFox smartFox = null;
	
	public void initSmartFox() throws JSONException{
		smartFox = new SmartFox(true);
		smartFox.loadConfig(false);
		
		smartFox.addEventListener(SFSEvent.CONNECTION, this);
		smartFox.addEventListener(SFSEvent.CONNECTION_LOST, this);
		smartFox.addEventListener(SFSEvent.LOGIN, this);
		smartFox.addEventListener(SFSEvent.LOGIN_ERROR, this);
		
		smartFox.addEventListener(SFSEvent.EXTENSION_RESPONSE, new IEventListener() {
			
			@Override
			public void dispatch(BaseEvent event) throws SFSException {
				if("userJoined".equals(event.getArguments().get("cmd"))){
					ISFSObject paramsRes = (ISFSObject)event.getArguments().get("params");
					
					String username = paramsRes.getUtfString("username");
					
					System.out.println(String.format("user %s entered", username));
				}
			}
		});
		
		connectServer();
	}
	
	private void connectToServer(final String ip, final int port)
	{
		//connect() method is called in separate thread
        //so it does not blocks the UI
		final SmartFox sfs = smartFox;
		new Thread() {
			@Override
			public void run() {
				sfs.connect(ip, port);
			}
		}.start();
	}
	

	@Override
	public void dispatch(BaseEvent event) throws SFSException {
		String type = event.getType();
		if(SFSEvent.CONNECTION.equalsIgnoreCase(type)){
			System.out.println("connection done");
			if(event.getArguments().get("success").equals(true)){
				System.out.println("connection success,begin login...");
				
				ISFSObject params = new SFSObject();
				params.putUtfString("role", "user");
				params.putUtfString("password", "e10adc3949ba59abbe56e057f20f883e");
				smartFox.send(new LoginRequest("88k"));
				
			}else{
				System.out.println("connection fail");
			}
			
			//
		}else if(SFSEvent.LOGIN.equalsIgnoreCase(type)){
			System.out.println("login success");
			
			//smartFox.send(new ExtensionRequest("getTime", new SFSObject(),smartFox.getLastJoinedRoom()));
			
		}else if(SFSEvent.LOGIN_ERROR.equalsIgnoreCase(type)){
			System.out.println("login err");
		}else if(SFSEvent.LOGOUT.equalsIgnoreCase(type)){
			System.out.println("log out");
		}
		
	}
	
	public void connectServer() throws JSONException{
		List<SFSNode> result = JsonConverter.convert(HttpUtils.connect(QUERY_IP));
		SFSNode minLoaded = SFSNodeUtils.getMiniLoadedNode(result);
		
		
		if(minLoaded != null){
			
			System.out.println("当前负载最小的节点:"+minLoaded.getNodeIp());
			
			connectToServer(minLoaded.getNodeIp(), minLoaded.getNodePort());
		}else{
			System.out.println("连接失败");
		}
	}
	
	
	public static void main(String[] args) throws Exception{
		
		new DemoClient().initSmartFox();
		
	}

}

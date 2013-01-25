package demo.sfs2x.client;

import java.net.InetAddress;
import java.net.UnknownHostException;

import org.json.JSONException;

import com.smartfoxserver.v2.entities.data.ISFSObject;
import com.smartfoxserver.v2.exceptions.SFSException;

import sfs2x.client.SmartFox;
import sfs2x.client.core.BaseEvent;
import sfs2x.client.core.IEventListener;
import sfs2x.client.core.SFSEvent;
import sfs2x.client.entities.User;
import sfs2x.client.requests.JoinRoomRequest;
import sfs2x.client.requests.LoginRequest;
import sfs2x.client.requests.PublicMessageRequest;

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
	
	private User currentUser = null;
	
	public void initSmartFox() throws JSONException{
		smartFox = new SmartFox(true);
		
		
		smartFox.addEventListener(SFSEvent.CONNECTION, this);
		smartFox.addEventListener(SFSEvent.CONNECTION_LOST, this);
		smartFox.addEventListener(SFSEvent.LOGIN, this);
		smartFox.addEventListener(SFSEvent.LOGIN_ERROR, this);
		smartFox.addEventListener(SFSEvent.ROOM_JOIN, this);
		
		smartFox.addEventListener(SFSEvent.EXTENSION_RESPONSE, new IEventListener() {
			
			@Override
			public void dispatch(BaseEvent event) throws SFSException {
				if("userJoined".equals(event.getArguments().get("cmd"))){
					ISFSObject paramsRes = (ISFSObject)event.getArguments().get("params");
					
					String username = paramsRes.getUtfString("username");
					
					System.out.println(String.format("user %s entered", username));
				}else if("userLeft".equals(event.getArguments().get("cmd"))){
					ISFSObject paramsRes = (ISFSObject)event.getArguments().get("params");
					String username = paramsRes.getUtfString("username");
					
					System.out.println(String.format("user %s left", username));
				}else if("clusterPublicMessage".equals(event.getArguments().get("cmd"))){
					ISFSObject paramsRes = (ISFSObject)event.getArguments().get("params");
					String username = paramsRes.getUtfString("username");
					String msg = paramsRes.getUtfString("message");
					
					System.out.println(String.format("%s 说 %s", username, msg));
				}
			}
		});
		
		smartFox.loadConfig(true);
		//connectServer();
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
	
	//获取IP最后一个段
	public String getClientIp() throws UnknownHostException{
		
		String wholeIp = InetAddress.getLocalHost().getHostAddress();
		
		return wholeIp.substring(wholeIp.lastIndexOf(".")+1);
	}
	

	@Override
	public void dispatch(BaseEvent event) throws SFSException {
		String type = event.getType();
		if(SFSEvent.CONNECTION.equalsIgnoreCase(type)){

			if(event.getArguments().get("success").equals(true)){
				
				
				try {
					String name = getClientIp()+"#"+System.currentTimeMillis();
					smartFox.send(new LoginRequest(name));
					
				} catch (UnknownHostException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}

				
			}else{
				System.out.println("connection fail");
			}
			
			//
		}else if(SFSEvent.LOGIN.equalsIgnoreCase(type)){
			System.out.println("login success,join the room");
			
			currentUser = (User)event.getArguments().get("user");
			
			
			
			smartFox.send(new JoinRoomRequest("demo"));
			//smartFox.send(new ExtensionRequest("getTime", new SFSObject(),smartFox.getLastJoinedRoom()));
			
		}else if(SFSEvent.ROOM_JOIN.equalsIgnoreCase(type)){
			System.out.println("room joined success, begin sending message");
			
			System.out.println(String.format("%s 开始发送消息", currentUser.getName()));

			smartFox.send(new PublicMessageRequest(String.format("%s 来了哦,大家欢迎吗?", currentUser.getName())));
		}
		
		else if(SFSEvent.LOGIN_ERROR.equalsIgnoreCase(type)){
			
			System.out.println("login err");
			
		}else if(SFSEvent.LOGOUT.equalsIgnoreCase(type)){
			System.out.println("log out");
		}
		
	}
	
//	public void connectServer() throws JSONException{
//		List<SFSNode> result = JsonConverter.convert(HttpUtils.connect(QUERY_IP));
//		SFSNode minLoaded = SFSNodeUtils.getMiniLoadedNode(result);
//		
//		
//		if(minLoaded != null){
//			
//			System.out.println("当前负载最小的节点:"+minLoaded.getNodeIp());
//			
//			connectToServer(minLoaded.getNodeIp(), minLoaded.getNodePort());
//		}else{
//			System.out.println("连接失败");
//		}
//	}
	
	
	public static void main(String[] args) throws Exception{
		
		new DemoClient().initSmartFox();
		
	}

}

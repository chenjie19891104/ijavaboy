package demo.sfs2x.client;

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
 * @author 陈杰
 *
 */
public class DemoClient implements IEventListener{
	
	private SmartFox smartFox = null;
	
	public void initSmartFox(){
		smartFox = new SmartFox(true);
		smartFox.loadConfig(true);
		
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
		
		
		//this.connectToServer("192.168.168.253");
	}
	
//	private void connectToServer(final String ip)
//	{
//		//connect() method is called in separate thread
//        //so it does not blocks the UI
//		final SmartFox sfs = smartFox;
//		new Thread() {
//			@Override
//			public void run() {
//				sfs.connect(ip, 9933);
//			}
//		}.start();
//	}
	

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
				smartFox.send(new LoginRequest("chenjie"));
				
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
	
	
	
	public static void main(String[] args){
		
		new DemoClient().initSmartFox();
	}

}

package demo.cluster.helper;

import com.smartfoxserver.v2.entities.Room;
import com.smartfoxserver.v2.extensions.SFSExtension;

public class RoomHelper {
	
//	public static Room getCurrentRoom(SFSExtension extension){
//		
//		return extension.getParentRoom();//这个方法仅仅对Room级别的Extension有效
//	}
	
	
	public static Room getRoomByName(SFSExtension extension, String roomName){
		
		return extension.getParentZone().getRoomByName(roomName);
	}

}

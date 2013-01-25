package demo.sfs2x.client;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class JsonConverter {
	
	/**
	 * 将JSON格式的数据解析为Map格式
	 * @param content
	 * @return
	 * @throws JSONException
	 */
	public static List<SFSNode> convert(String content) throws JSONException{
		
		//System.out.println("解析:"+content);
		
		JSONObject jsonObj = new JSONObject(content);
		
		JSONArray array = (JSONArray)jsonObj.get("servers");
		
		if(array != null && array.length() > 0){
			//List<Map<String, Object>> result = new ArrayList<Map<String,Object>>();
			List<SFSNode> result = new ArrayList<SFSNode>();
			for(int i=0; i<array.length(); i++){
				JSONObject item = array.getJSONObject(i);
				//Map<String, Object> itemMap = new HashMap<String, Object>();
				
//				itemMap.put("nodeIp", item.get("nodeIp"));
//				itemMap.put("nodePort", item.get("nodePort"));
//				itemMap.put("currentUsers", item.get("currentUsers"));
//				itemMap.put("maxUsers", item.get("maxUsers"));
				
				//result.add(itemMap);
				
				SFSNode node = new SFSNode();
				node.setNodeIp(item.getString("nodeIp"));
				node.setNodePort(item.getInt("nodePort"));
				node.setCurrentUsers(item.getInt("currentUsers"));
				node.setMaxUsers(item.getInt("maxUsers"));
				
				result.add(node);
				
			}
			
			return result;
		}
		
		return null;
	}
}

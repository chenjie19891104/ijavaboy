package org.export.simple;

import java.util.List;

import net.sf.json.JSONArray;
import net.sf.json.JSONObject;

/**
 * @author chenjie
 * 2012-12-7
 */
public class ExportData {
	
	private String[] headers;
	
	private List<String[]> values;

	public final String[] getHeaders() {
		return headers;
	}

	public final void setHeaders(String[] headers) {
		this.headers = headers;
	}

	public final List<String[]> getValues() {
		return values;
	}

	public final void setValues(List<String[]> values) {
		this.values = values;
	}
	
	public String toText(){
		
		if(this.values != null && this.values.size() > 0){
			StringBuilder sb = new StringBuilder();
			for(int i=0; i<this.values.size(); i++){
				
				String[] item = this.values.get(i);
				
				for(String str : item){
					sb.append(str).append("\t");
				}
				
				sb.deleteCharAt(sb.length()-1).append("\n"); //删除最后一个\t，再添加一个换行符
				
			}
			
			sb.deleteCharAt(sb.length()-1); //删除最后一个换行符
			
			return sb.toString();
		}
		
		
		return null;
	}
	
	public JSONArray toJSONArray(){

		if(this.values != null && this.headers != null){
			JSONArray array = new JSONArray();
			for(String[] value : this.values){
				JSONObject item = this.toJSONObject(this.headers, value);
				
				if(item != null){
					array.add(item);
				}
			}
			
			return array;
		}
		
		return null;
	}
	
	private JSONObject toJSONObject(String[] headers, String[] values){
		if(values == null || headers == null || values.length != headers.length){
			System.out.println("generate json object error");
			System.out.println("header length:"+headers.length + "; value length:"+values.length);
			return null;
		}
		
		JSONObject json = new JSONObject();
		for(int i=0; i<headers.length; i++){
			String key = headers[i];
			String value = values[i];
			json.put(key, value);
		}
		
		return json;
	}

}

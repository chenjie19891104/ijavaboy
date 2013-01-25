package demo.sfs2x.client;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

public class HttpUtils {
	
	/**
	 * 根据IP指定的地址,访问网络,获取内容
	 * @param ip
	 * @return
	 */
	public static String connect(String ip){
		
		HttpURLConnection conn = null;
		
		try {
			URL url = new URL(ip);
			conn = (HttpURLConnection)url.openConnection();
			
			conn.setConnectTimeout(5000);
			conn.setRequestMethod("GET");
			
			//Object content = conn.getContent();
			
			String contentStr = read(conn.getInputStream());
			
			return contentStr;
			
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}finally{
			if(conn != null){
				conn.disconnect();
			}
		}
		
		return null;
	}
	
	
	private static String read(InputStream in) throws IOException{
		
		BufferedReader reader = new BufferedReader(new InputStreamReader(in));
		
		StringBuilder result = new StringBuilder();
		
		String line = reader.readLine();
		
		while(line != null){
			result.append(line);
			line = reader.readLine();
		}
		
		return result.toString();
	}

}

package org.export.simple.utils;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintWriter;

/**
 * @author chenjie
 * 2012-12-7
 */
public final class FileUtils {
	
	/**
	 * 获取文件扩展名
	 * @param file
	 * @return
	 */
	public static final String getExtensionName(String file){
		
		if(null == file || file.trim().length()==0)return null;
		
		if(!file.contains(".")){
			return null;
		}
		
		return new String(file.substring(file.lastIndexOf(".")));
		
	}
	
	/**
	 * 获取json输出地址
	 * @param dict
	 * @param fileName
	 * @return
	 */
	public static final String getDestFileName(String dict, String fileName){
		
		String name = new String(fileName.substring(0, fileName.lastIndexOf(".")));
		
		return dict + name;
		
	}
	
	/**
	 * 获取输出目录
	 * @param dict
	 * @return
	 */
	public static final String getDestDirectory(String dict){
		
		return new StringBuilder().append(dict).append(File.separator).append("export").append(File.separator).toString();
	}
	
	/**
	 * 将data写入到指定的文件
	 * @param data
	 * @param dest
	 * @throws IOException
	 */
	public static final void writeToFile(String data, String dest) throws IOException{
		File file = new File(dest);
		
		if(!file.exists()){
			file.createNewFile();
		}
		
		FileOutputStream fos = new FileOutputStream(file);
		
		BufferedWriter bw = new BufferedWriter(new PrintWriter(fos, true));
		
		bw.write(data);
		
		bw.close();
	}

}

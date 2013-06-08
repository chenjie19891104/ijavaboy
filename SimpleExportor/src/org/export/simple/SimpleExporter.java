package org.export.simple;

import java.io.File;
import java.io.IOException;

import org.export.simple.utils.ExportUtils;
import org.export.simple.utils.FileUtils;

import net.sf.json.JSONArray;

/**
 * @author chenjie
 * 2012-12-7
 */
public class SimpleExporter {
	
	public static final int TYPE_JSON = 1;
	public static final int TYPE_TEXT = 2;
	
	/**
	 * 将指定目录下的所有.xls文件转换为json格式
	 * @param directory
	 * @throws IOException
	 */
	public static void exportDirectory(String directory, int type) throws IOException{
		
		final File dict = new File(directory);
		
		if(!dict.isDirectory()){
			return;
		}
		
		final File[] files = dict.listFiles();
		
		if(files != null){
			//创建输出目录
			final String destDirect = FileUtils.getDestDirectory(directory);
			final File destDict = new File(destDirect);
			if(!destDict.exists()){
				destDict.mkdirs();
			}
			
			//导出每一个.xls文件
			for(int i=0; i<files.length; i++){
				final File file = files[i];
				
				if(".xls".equalsIgnoreCase(FileUtils.getExtensionName(file.getName()))){
					
					final String dest = FileUtils.getDestFileName(destDirect, file.getName());
					
					System.out.println("export--"+dest);
					
					exportFile(file, dest, type);
				}
				
			}
			
		}
		
	}
	
	/**
	 * 导出某个文件
	 * @param path
	 * @param type
	 * @throws IOException
	 */
	public static void exportFile(String path, int type) throws IOException{
		if(path == null || path.trim().length() == 0)return;
		
		if(!".xls".equalsIgnoreCase(FileUtils.getExtensionName(path))){
			
			return;
			
		}
		
		String dest = new String(path.substring(0, path.lastIndexOf(".")));
		
		exportFile(path, dest, type);
	}
	
	/**
	 * 将指定的xls文件转换为JSON对象，并输出到destPath指定的文件
	 * @param path
	 * @param destPath
	 * @throws IOException
	 */
	private static void exportFile(String path, String destPath, int type) throws IOException{
		
		File file = new File(path);
		
		if(!file.exists()){
			System.out.println(path + " is not exists");
			return;
		}
		

		exportFile(file, destPath, type);
		
	}
	
	private static void exportFile(File source, String destPath, int type) throws IOException{
		
		if(type == TYPE_JSON){
			exportFileToJSON(source, destPath);
		}else if(type == TYPE_TEXT){
			exportFileToText(source, destPath);
		}
	}
	
	/**
	 * 将指定的xls文件转换为JSON对象，并输出到destPath指定的文件
	 * @param path
	 * @param destPath
	 * @throws IOException
	 */
	private static void exportFileToJSON(File source, String destPath) throws IOException{
		
		ExportData data = ExportUtils.exportToJSON(source);
		
		if(data == null){
			return;
		}
		
		JSONArray array = data.toJSONArray();
		
		if(array != null){
			FileUtils.writeToFile(array.toString(), destPath);
		}else{
			System.out.println(destPath + " parse null");
		}
		
	}
	
	/**
	 * 将指定的xls文件转换为Text格式，并输出到destPath指定的文件
	 * @param source
	 * @param destPath
	 * @throws IOException
	 */
	private static void exportFileToText(File source, String destPath) throws IOException{
		ExportData data = ExportUtils.exportToJSON(source);
		
		if(data == null){
			return;
		}
		
		String result = data.toText();
		
		if(result != null){
			FileUtils.writeToFile(result.toString(), destPath);
		}else {
			System.out.println(destPath + " parse null");
		}
	}

}

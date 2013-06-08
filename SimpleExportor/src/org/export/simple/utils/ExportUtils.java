package org.export.simple.utils;

import java.io.File;
import java.io.FileInputStream;
import java.util.ArrayList;
import java.util.List;

import org.apache.poi.hssf.usermodel.HSSFCell;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.export.simple.ExportData;


/**
 * @author chenjie
 * 2012-12-7
 */
public class ExportUtils {

	
	/**
	 * 将指定的xls文件转换为JSONArray对象
	 * @param path
	 * @return
	 */
	public static ExportData exportToJSON(File file){
		
		try {
			
			FileInputStream fis = new FileInputStream(file);
			
			HSSFWorkbook wbs = new HSSFWorkbook(fis);
			HSSFSheet childSheet = wbs.getSheetAt(0);
			
			final int rowNum = childSheet.getLastRowNum();
			System.out.println("The table has row :" + rowNum);
			
			if(rowNum <= 0){
				return null;
			}
			
			ExportData data = new ExportData();
			
			//找到第一个非空的行
			int firstRow = 0;
			HSSFRow head = childSheet.getRow(0);
			while(head == null && firstRow < rowNum){
				firstRow++;
				head = childSheet.getRow(firstRow);
			}
			
			head = childSheet.getRow(firstRow);
			String[] headers = handleRow(head, 0);
			
			data.setHeaders(headers);
			
			List<String[]> items = new ArrayList<String[]>();
			
			for(int i=firstRow+1; i<=rowNum; i++){
				
				HSSFRow row = childSheet.getRow(i);
				if(row != null){
					
					String[] values = handleRow(row, headers.length);
					
					items.add(values);
					
				}
				
			}
			
			data.setValues(items);
			
			return data;
			
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		return null;
	}
	
	/**
	 * 处理每一行
	 * @param row
	 * @return
	 */
	private static String[] handleRow(HSSFRow row, int headerLength){
		
		final int cellSize = Math.max(row.getLastCellNum(), headerLength);
		String[] result = new String[cellSize];
		for(int j=0; j<cellSize; j++){
			
			HSSFCell cell = row.getCell(j);
			
			if(null != cell){
				switch(cell.getCellType()){
				case HSSFCell.CELL_TYPE_NUMERIC:
					result[j] = cell.getNumericCellValue()+"";
					break;
				case HSSFCell.CELL_TYPE_BLANK:
					result[j] = "";
					break;
				case HSSFCell.CELL_TYPE_BOOLEAN:
					result[j] = cell.getBooleanCellValue() + "";
					break;
				case HSSFCell.CELL_TYPE_ERROR:
					result[j] = cell.getErrorCellValue() + "";
					break;
				case HSSFCell.CELL_TYPE_FORMULA:
					result[j] = cell.getCellFormula();
					break;
				case HSSFCell.CELL_TYPE_STRING:
					result[j] = cell.getStringCellValue();
					break;
				}
				
			}else{
				result[j] = "";
			}
			
		}
		
		return result;
	}
	
}

package org.jdbc.async.parser;

import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.Map;

/**
 * 多种方式转换查询结果
 * @author chenjie
 * 2012-12-4
 */
public class RowParser {
	
	public static Object[] parseArray(ResultSet row) throws SQLException{

		ResultSetMetaData meta = row.getMetaData();
		
		final int count = meta.getColumnCount();
		
		Object[] result = new Object[count];
		
		for(int i=0; i<count; i++){
			result[i] = row.getObject(i+1); //rs类索引从1开始
		}
		
		return result;
	}
	
	public static Map<String, Object> parseMap(ResultSet row) throws SQLException{
		
		ResultSetMetaData meta = row.getMetaData();
		
		Map<String, Object> result = new HashMap<String, Object>();
		
		final int count = meta.getColumnCount();
		
		for(int i=1; i<count; i++){
			result.put(meta.getColumnName(i), row.getObject(i)); //这里数据库中字段名的大小写问题，需要考虑
		}
		
		return result;
	}
	
	public static <T> T parseBean(ResultSet row){
		
		
		return null;
	}


}

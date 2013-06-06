package org.jdbc.async.test;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.template.IJdbcTemplate;
import org.jdbc.async.template.async.AsyncJdbcTemplate;

/**
 * @author chenjie
 * 2012-12-1
 */
public class MainTest {
	
	public static void main(String[] args) throws SimpleSQLException{
		
//		IJdbcTemplate<Object[]> template = new AsyncJdbcTemplate();
//		
//		long timeBegin = System.currentTimeMillis();
//		System.out.println("timeBegin : " + timeBegin);
//		for(int i=0; i<1000; i++){
//			
//			try {
//				String sql = "insert into person(name) values(?)";
//				Object[] params = {"name"+i};
//				
//				template.executeUpdate(sql, params);
//				
//			} catch (Exception e) {
//				
//				e.printStackTrace();
//			}
//		}
//		
//		long timeEnd = System.currentTimeMillis();
//		
//		System.out.println("time to insert : " + (timeEnd - timeBegin));
//		
//		while(true){
//			System.out.println("waiting to finished");
//		}
		
		testRead();
	}
	
	
	public static void testRead() throws SimpleSQLException{
		
		String sql = "select * from monster where id = 1";
		
		IJdbcTemplate<Object[]> template = new AsyncJdbcTemplate();
		
		Object[] result = template.uniqueResult(sql);
		
		if(result == null){
			System.out.println("nullllll");
			return;
		}
		
		for(Object obj : result){
			System.out.println(obj);
		}
	}

}

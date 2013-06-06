package org.jdbc.async.utils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;
import java.util.Map;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.jdbc.async.processor.IResultSetProcessor;
import org.jdbc.async.processor.array.ArrayProcessor;
import org.jdbc.async.processor.map.MapProcessor;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;


/**
 * @author chenjie
 * 2012-12-1
 */
public final class QueryUtils {
	
	private final static Logger logger = LoggerFactory.getLogger(QueryUtils.class);
	
	/**
	 * 执行一次查询，结果以List<Object[]>形式返回
	 * @param provider
	 * @param sql
	 * @param params
	 * @return
	 * @throws SQLException
	 */
	public static List<Object[]> arrayQuery(IPoolProvider provider, String sql, Object...params) throws SimpleSQLException{
		
		Connection conn = null;
		PreparedStatement stmt = null;
		
		List<Object[]> array = null; 
	    try {
			
			conn = provider.getConnection();
			
			if(conn != null){
				
				stmt = conn.prepareStatement(sql);
				
				if(params != null){
					int index = 1;
					for(Object p : params){
						stmt.setObject(index++, p);
					}
				}
				
				ResultSet result = stmt.executeQuery();
				
				logger.debug(String.format("query-sql:", stmt.toString()));
				
				IResultSetProcessor<Object[]> processor = new ArrayProcessor();

				array = processor.handleSet(result);
			}else {
				logger.error("can not get an available connection from pool");
			}
			

		}catch(SQLException e){
			
			throw new SimpleSQLException(e);
		}
	    
	    finally{
			
			if(stmt != null){
				try {
					stmt.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e);
				}
			}
			
			if(conn != null){
				try {
					conn.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e);
				}
			}
			
		}
	    
	    return array;
	}
	
	/**
	 * 执行一次查询，结果以List<Map>形式返回
	 * @param provider
	 * @param sql
	 * @param params
	 * @return
	 * @throws SQLException
	 */
	public static List<Map<String, Object>> mapQuery(IPoolProvider provider, String sql, Object...params) throws SimpleSQLException{
		
		Connection conn = null;
		PreparedStatement stmt = null;
		
		List<Map<String, Object>> map = null;
	    try {
			
			conn = provider.getConnection();
			
			if(conn != null){
				
				stmt = conn.prepareStatement(sql);
				
				if(params != null){
					int index = 1;
					for(Object p : params){
						stmt.setObject(index++, p);
					}
				}
				
				ResultSet result = stmt.executeQuery();
				
				logger.debug(String.format("query-sql:", stmt.toString()));
				
				IResultSetProcessor<Map<String, Object>> processor = new MapProcessor();

				map = processor.handleSet(result);
			}
			

		}catch(SQLException e){
			
			throw new SimpleSQLException(e);
		}
	    finally{
			
			if(stmt != null){
				try {
					stmt.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e);
				}
			}
			
			if(conn != null){
				try {
					conn.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e);
				}
			}
			
		}
	    
	    return map;
	}

}

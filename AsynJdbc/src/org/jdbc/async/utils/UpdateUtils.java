package org.jdbc.async.utils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.Date;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

/**
 * @author chenjie
 * 2012-12-1
 */
public final class UpdateUtils {
	
	private final static Logger logger = LoggerFactory.getLogger(UpdateUtils.class);
	
	/**
	 * 执行一次更新操作，指定连接Connection
	 * @param conn
	 * @param sql
	 * @param params
	 * @throws SimpleSQLException
	 */
	public static void update(Connection conn, String sql, Object...params) throws SimpleSQLException{
		
		PreparedStatement stmt = null;

	    try {
			
			if(conn != null){
				
				stmt = conn.prepareStatement(sql);
				
				if(params != null){
					int index = 1;
					for(Object p : params){
						stmt.setObject(index++, p);
					}
				}
				
				stmt.executeUpdate();
				
				logger.debug(String.format("update-sql:", stmt.toString()));
			}
			

		}catch(SQLException e){
			
			throw new SimpleSQLException(e.getMessage(), e);
		}
	    
	    finally{
			
			if(stmt != null){
				try {
					
					stmt.close();
					
				} catch (SQLException e) {
					
					throw new SimpleSQLException(e.getMessage(), e);
				}
				
				stmt = null;
			}
		}
		
	}
	
	/**
	 * 执行一次更新操作，需指定连接池
	 * @param poolProvider
	 * @param sql
	 * @param params
	 * @throws SimpleSQLException
	 */
	public static void update(IPoolProvider poolProvider, String sql, Object...params) throws SimpleSQLException{
		
		Connection conn = null;
		PreparedStatement stmt = null;

	    try {
			
			conn = poolProvider.getConnection();
			
			if(conn != null){
				
				stmt = conn.prepareStatement(sql);
				
				if(params != null){
					int index = 1;
					for(Object p : params){
						stmt.setObject(index++, p);
					}
				}
				
				stmt.executeUpdate();
				
				SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
				
				logger.debug(String.format("%s update-sql: %s", sdf.format(new Date()), stmt.toString()));
			}
			

		}catch(SQLException e){
			
			throw new SimpleSQLException(e.getMessage(), e);
			
		}finally{
			
			if(stmt != null){
				try {
					stmt.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e.getMessage(), e);
				}
				stmt = null;
			}
			
			if(conn != null){
				try {
					conn.close();
				} catch (SQLException e) {
					throw new SimpleSQLException(e.getMessage(), e);
				}
				conn = null;
			}
			
		}
	}

}

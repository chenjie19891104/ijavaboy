package org.jdbc.async.transaction;

import java.sql.Connection;
import java.sql.SQLException;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.pool.IPoolProvider;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class TransactionUtils{

	private static final Logger logger = LoggerFactory.getLogger(TransactionUtils.class);
	
	public static Object runInTransaction(IPoolProvider poolProvider, TransactionCallback callback) {
		
		Connection conn = null;
		Object result = null;
		
	    try {
			
			conn = poolProvider.getConnection();
			conn.setAutoCommit(false);
			
			if(conn != null){
				result = callback.callback(conn);
				
				conn.commit();
				conn.setAutoCommit(true);
			}

		} catch (SimpleSQLException e) {
			
			if(conn != null){
				try {
					conn.rollback();
				} catch (SQLException e1) {
					logger.error("rollback failed");
					e1.printStackTrace();
				}
			}
			
			logger.error("callback execute failed, rollback the update");
			e.printStackTrace();
		} catch (SQLException e){
			
			if(conn != null){
				try {
					conn.rollback();
				} catch (SQLException e1) {
					logger.error("rollback failed");
					e1.printStackTrace();
				}
			}
			
			logger.error("callback execute failed, rollback the update");
			
		}finally{
			
			if(conn != null){
				try {
					conn.close();
					conn = null;
				} catch (SQLException e) {
					logger.error("callback execute failed, rollback the update");
					e.printStackTrace();
				}
			}
			
		}		
		
	    return result;
		
	}

}

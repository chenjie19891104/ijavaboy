package org.jdbc.async.pool.bonecp;

import java.sql.Connection;
import java.sql.SQLException;

import org.jdbc.async.config.SimpleConfig;
import org.jdbc.async.pool.IPoolProvider;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.jolbox.bonecp.BoneCP;
import com.jolbox.bonecp.BoneCPConfig;

/**
 * BoneCP 连接池实现
 * @author chenjie
 *
 */
public class BoneCPProvider implements IPoolProvider {

	private final Logger logger = LoggerFactory.getLogger(BoneCPProvider.class);
	
	private BoneCP pool = null;
	
	private SimpleConfig connectionConfig;
	
	public BoneCPProvider(SimpleConfig config){
		this.connectionConfig = config;
		
		this.init();
	}
	
	@Override
	public Connection getConnection() throws SQLException {
		
		if(pool != null){
			
			logger.debug("get a new connection from bonecp pool");
			return pool.getConnection();
		}
		
		logger.error("getConnection--> pool is null; please make sure the pool has been instantiated");
		
		return null;
	}

	@Override
	public void init(){
		
		logger.info("used bonecp as the jdbc connection pool");
		
		if(this.connectionConfig == null){
			throw new RuntimeException("The connectionConfig is null");
		}
		
		try {
			Class.forName(this.connectionConfig.getDriver());
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
			return;
		}
		
		BoneCPConfig config = new BoneCPConfig();
		config.setJdbcUrl(this.connectionConfig.getConnectionString()); // jdbc url specific to your database, eg jdbc:mysql://127.0.0.1/yourdb
		config.setUsername(this.connectionConfig.getUsername()); 
		config.setPassword(this.connectionConfig.getPassword());
		
		config.setMinConnectionsPerPartition(5);
		config.setMaxConnectionsPerPartition(20);
		config.setPartitionCount(1);
		
		
		try {
			pool = new BoneCP(config);
		} catch (SQLException e) {
			
			logger.error("can not load the driver class");
			e.printStackTrace();
		}
		
		if(pool != null){
			logger.debug("the bonecp connection pool has been instantiated");
		}else {
			logger.error("the bonecp pool is null");
		}
		
	}

	@Override
	public void destroy() {
		
		if(pool != null){
			
			logger.debug("now shutdown the bonecp connection pool");
			
			pool.shutdown();
		}
		
	}


}

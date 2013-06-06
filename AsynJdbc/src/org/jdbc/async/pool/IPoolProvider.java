package org.jdbc.async.pool;

import java.sql.Connection;
import java.sql.SQLException;

/**
 * 连接池提供者接口
 * 
 * 现有的连接池实现有<code>BoneCPProvider</code>
 * 
 * @author chenjie
 * 2012-12-4
 */
public interface IPoolProvider {
	
	public void init() throws Exception;
	
	public void destroy();
	
	public Connection getConnection() throws SQLException;

}

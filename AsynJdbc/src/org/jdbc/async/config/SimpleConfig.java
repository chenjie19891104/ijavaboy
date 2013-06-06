package org.jdbc.async.config;

/**
 * 数据库连接配置信息
 * @author chenjie
 * 2012-12-4
 */
public class SimpleConfig {
	
	public static final String DEFAULT_CONFIG_NAME = "connection.properties";
	
	private String driver;
	
	private String connectionString;
	
	private String username;
	
	private String password;

	public String getDriver() {
		return driver;
	}

	public void setDriver(String driver) {
		this.driver = driver;
	}

	public String getConnectionString() {
		return connectionString;
	}

	public void setConnectionString(String connectionString) {
		this.connectionString = connectionString;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}
	
	public static SimpleConfig getDefault(){
		
		SimpleConfig config = new SimpleConfig();
		config.setDriver("com.mysql.jdbc.Driver");
		config.setConnectionString("jdbc:mysql://192.168.1.121:3306/netgame");
		config.setUsername("chenjie");
		config.setPassword("chenjie");
		
		return config;
	}

}

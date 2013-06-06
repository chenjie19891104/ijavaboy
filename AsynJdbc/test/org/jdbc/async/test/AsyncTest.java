package org.jdbc.async.test;

import org.jdbc.async.config.ConfigLoader;
import org.jdbc.async.config.SimpleConfig;
import org.jdbc.async.pool.IPoolProvider;
import org.jdbc.async.pool.bonecp.BoneCPProvider;
import org.jdbc.async.template.async.AsyncJdbcTemplate;
import org.junit.Before;
import org.junit.Test;

/**
 * @author chenjie
 * 2012-12-1
 */
public class AsyncTest {
	
	private SimpleConfig config;
	private IPoolProvider provider;
	
	private AsyncJdbcTemplate template;

	@Before
	public void setUp() throws Exception {
		this.config = ConfigLoader.getInstance().load(SimpleConfig.DEFAULT_CONFIG_NAME);
		this.provider = new BoneCPProvider(config);
		this.template = new AsyncJdbcTemplate(this.provider);
	}

	@Test
	public void testAsyncJdbcTemplate() {
		
		for(int i=0; i<100000; i++){
			
			try {
				String sql = "update person set name = ?";
				Object[] params = {"name"+i};
				
				this.template.executeUpdate(sql, params);
			} catch (Exception e) {
				
				e.printStackTrace();
			}
		}
		

	}

}

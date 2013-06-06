package org.jdbc.async.event;

/**
 * 数据库更新事件
 * @author chenjie
 * 2012-12-1
 */
public class UpdateEvent {

	private String sql;
	private Object[] params;
	
	public UpdateEvent(String sql, Object[] params){
		
		this.sql = sql;
		this.params = params;
	}
	
	public final String getSql() {
		return sql;
	}
	public final void setSql(String sql) {
		this.sql = sql;
	}
	public final Object[] getParams() {
		return params;
	}
	public final void setParams(Object[] params) {
		this.params = params;
	}
	
	
}


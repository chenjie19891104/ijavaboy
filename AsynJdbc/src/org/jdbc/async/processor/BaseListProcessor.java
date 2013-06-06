package org.jdbc.async.processor;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;


/**
 * 查询结果是列表时的处理基类
 * @author chenjie
 * 2012-12-4
 */
public abstract class BaseListProcessor<T> implements IResultSetProcessor<T> {

	@Override
	public final List<T> handleSet(ResultSet rs) throws SQLException {
		
		List<T> result = new ArrayList<T>();
		while(rs.next()){
			
			result.add(this.handleRow(rs));
			
		}
		return result;
	}
	
	protected abstract T handleRow(ResultSet rs) throws SQLException;

}

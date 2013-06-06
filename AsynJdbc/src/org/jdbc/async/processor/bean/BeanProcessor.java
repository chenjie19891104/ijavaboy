package org.jdbc.async.processor.bean;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

import org.jdbc.async.parser.BeanParser;
import org.jdbc.async.processor.IResultSetProcessor;

/**
 * 以实体封装单挑记录的查询结果
 * @author chenjie
 * 2012-12-4
 */
public class BeanProcessor<T> implements IResultSetProcessor<T> {

	private Class<T> type = null;
	
	private BeanParser beanParser = null;
	
	public BeanProcessor(Class<T> type){
		
		this.type = type;
		
		this.beanParser = new BeanParser();
	}

	public T handleRow(ResultSet rs) throws SQLException {
		
		if(rs.next()){
			
			return this.beanParser.parseBean(rs, type);
		}
		
		return null;
	}

	@Override
	public List<T> handleSet(ResultSet rs) throws SQLException {

		return this.beanParser.parseBeanList(rs, type);
	}

}

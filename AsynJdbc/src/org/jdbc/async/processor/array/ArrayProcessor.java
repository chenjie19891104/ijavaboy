package org.jdbc.async.processor.array;

import java.sql.ResultSet;
import java.sql.SQLException;

import org.jdbc.async.parser.RowParser;
import org.jdbc.async.processor.BaseListProcessor;

/**
 * 以Object[]数组的形式封装单条记录查询结果
 * @author chenjie
 * 2012-12-4
 */
public class ArrayProcessor extends BaseListProcessor<Object[]> {
	
	@Override
	protected Object[] handleRow(ResultSet rs) throws SQLException {
		
		return RowParser.parseArray(rs);
	}

}

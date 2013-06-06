package org.jdbc.async.processor.map;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Map;

import org.jdbc.async.parser.RowParser;
import org.jdbc.async.processor.BaseListProcessor;

/**
 * 以Map的形式封装单挑记录查询结果
 * @author chenjie
 * 2012-12-4
 */
public class MapProcessor extends BaseListProcessor<Map<String, Object>> {

	@Override
	public Map<String, Object> handleRow(ResultSet rs) throws SQLException {
		
		if(rs.next()){
			return RowParser.parseMap(rs);
		}else {
			return null;
		}
		
	}

}

package org.jdbc.async.template;

import java.sql.SQLException;
import java.util.List;

import org.jdbc.async.exception.SimpleSQLException;
import org.jdbc.async.transaction.TransactionCallback;

/**
 * 封装JDBC操作
 * @author chenjie
 * 2012-12-4
 */
public interface IJdbcTemplate<T> {

	
	public void destroy();
	
	/**
	 * 查询记录数
	 * @param sql
	 * @param params
	 * @return
	 * @throws SQLException
	 */
	public long countResult(String sql, Object...params) throws SimpleSQLException;
	
	/**
	 * 查询唯一记录,结果多于一条,则抛出异常
	 * @param sql
	 * @param params
	 * @return
	 * @throws SQLException
	 */
	public T uniqueResult(String sql, Object...params) throws SimpleSQLException;
	
	/**
	 * 查询多条记录
	 * @param sql
	 * @param params
	 * @return
	 * @throws SQLException
	 */
	public List<T> listResult(String sql, Object...params) throws SimpleSQLException;
	
	public void executeUpdate(String sql, Object...params) throws SimpleSQLException;
	
	/**
	 * 事务控制
	 * @param callback : 事务控制回调接口
	 * @return
	 */
	public Object runInTransaction(TransactionCallback callback);
}

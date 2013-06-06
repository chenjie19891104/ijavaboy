package org.jdbc.async.transaction;

import java.sql.Connection;

import org.jdbc.async.exception.SimpleSQLException;

public interface TransactionCallback {
	
	public Object callback(Connection connection) throws SimpleSQLException;

}

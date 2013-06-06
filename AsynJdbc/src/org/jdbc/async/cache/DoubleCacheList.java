package org.jdbc.async.cache;

import java.util.LinkedList;
import java.util.List;

/**
 * 双缓冲队列
 * 
 * 隔离线程读和线程写
 * 
 * 当逻辑线程读队列空时，同步两个队列(IO线程阻塞)，并交换读队列和写队列
 * @author chenjie
 * 2012-11-30
 */
public class DoubleCacheList<T> implements CacheList<T>{
	
	private final List<T> readQueue; //逻辑线程读队列
	
	private final List<T> writeQueue; //IO线程写队列
	
	private final Object readLock = new Object();
	private final Object writeLock = new Object();
	
	public DoubleCacheList(){
		//Collections.synchronizedList(new LinkedList<T>()); 
		this.readQueue = new LinkedList<T>();//new SynchronizedLinkedList<T>(new LinkedList<T>());
		
		//Collections.synchronizedList(new LinkedList<T>());
		this.writeQueue = new LinkedList<T>();//new SynchronizedLinkedList<T>(new LinkedList<T>());
	}
	
	@Override
	public T read(){
		
		synchronized (readLock) {
			
			if(this.readQueue.size() == 0){
				
				this.swap();
			}
			
			if(this.readQueue.size() > 0){
				
				return this.readQueue.remove(0);
			}
			
			return null;
		}
		
		
	}


	@Override
	public void write(T data){
		
		synchronized (writeLock) {
			
			this.writeQueue.add(data);
			
		}
		
		
	}
	
	/**
	 * 交换两个队列
	 */
	public void swap(){
		
		synchronized (writeLock) {
			
			this.readQueue.addAll(this.writeQueue);
			this.writeQueue.clear();
		}
	}
	
	
}

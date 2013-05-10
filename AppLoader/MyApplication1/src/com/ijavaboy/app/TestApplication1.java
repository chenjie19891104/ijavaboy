package com.ijavaboy.app;

import com.ijavaboy.application.IApplication;

/**
 * @author ijavaboy
 * 2013-5-10
 */
public class TestApplication1 implements IApplication{

	@Override
	public void init() {
		System.out.println("TestApplication1-->init");
	}

	@Override
	public void execute() {
		System.out.println("TestApplication1-->do something");
	}

	@Override
	public void destory() {
		System.out.println("TestApplication1-->destoryed");
	}

}

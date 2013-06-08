package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;
import org.config.cache.utils.StringUtils;

/**
 * 怪物组刷新配置
 * @author chenjie
 * 2012-12-13
 */
public class MonsterRefreshConfig implements IConfig {

	private Integer stength; //强度
	private Integer type; //类型
	private Integer groupID; //怪物组ID
	
	@Override
	public void fromStringArray(StringArray values) {
		
		this.stength = values.getInt();
		this.type = values.getInt();
		this.groupID = values.getInt();
		
	}

	@Override
	public String getKey() {

		return null;
	}

	public final Integer getStength() {
		return stength;
	}

	public final void setStength(Integer stength) {
		this.stength = stength;
	}

	public final Integer getType() {
		return type;
	}

	public final void setType(Integer type) {
		this.type = type;
	}

	public final Integer getGroupID() {
		return groupID;
	}

	public final void setGroupID(Integer groupID) {
		this.groupID = groupID;
	}

	public String toString(){
		
		return StringUtils.toString(getClass(), this);
	}
}

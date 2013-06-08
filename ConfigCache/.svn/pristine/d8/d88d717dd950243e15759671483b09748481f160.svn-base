package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;

/**
 * 城池路线配置表
 * @author chenjie
 * 2012-12-12
 */
public class CityRouteConfig implements IConfig {

	private Integer id; //配置项ID
	private Integer startCityID; //路线起点城池ID
	private Integer endCityID; //路线终点城池ID
	private Integer distance; //上面两个城池之间的距离
	
	@Override
	public void fromStringArray(StringArray values) {
		
		this.id = values.getInt();
		this.startCityID = values.getInt();
		this.endCityID = values.getInt();
		this.distance = values.getInt();
		
	}

	@Override
	public String getKey() {
		
		return this.id+"";
	}

	public final Integer getStartCityID() {
		return startCityID;
	}

	public final void setStartCityID(Integer startCityID) {
		this.startCityID = startCityID;
	}

	public final Integer getEndCityID() {
		return endCityID;
	}

	public final void setEndCityID(Integer endCityID) {
		this.endCityID = endCityID;
	}

	public final Integer getDistance() {
		return distance;
	}

	public final void setDistance(Integer distance) {
		this.distance = distance;
	}

	public final void setId(Integer id) {
		this.id = id;
	}

	public final Integer getId() {
		return id;
	}

	
}

package org.config.cache.data;

import org.config.cache.StringArray;
import org.config.cache.core.IConfig;
import org.config.cache.utils.StringUtils;

/**
 * 掉落配置表
 * @author chenjie
 * 2012-12-13
 */
public class DropConfig implements IConfig {
	public static final int DROP_ITEM_COUNT = 10;
	
	private Integer id; //ID
	private String name; //名称
	private Integer dropNum; //掉落物品数
	
	private Integer[] itemIDs; //物品ID
	private Integer[] itemMinNums; //最小掉落数
	private Integer[] itemMaxNums; //最大掉落数
	private Integer[] itemRates; //掉落比重
	private Integer[] itemPrice; //掉落的价值

	@Override
	public void fromStringArray(StringArray values) {
		
		id = values.getInt();
		name = values.getString();
		dropNum = values.getInt();
		
		itemIDs = new Integer[DROP_ITEM_COUNT];
		itemMinNums = new Integer[DROP_ITEM_COUNT];
		itemMaxNums = new Integer[DROP_ITEM_COUNT];
		itemRates = new Integer[DROP_ITEM_COUNT];
		itemPrice = new Integer[DROP_ITEM_COUNT];
		
		for(int i=0; i<DROP_ITEM_COUNT; i++){
			itemIDs[i] = values.getInt();
			itemMinNums[i] = values.getInt();
			itemMaxNums[i] = values.getInt();
			itemRates[i] = values.getInt();
			itemPrice[i] = values.getInt();
		}
		
	}

	@Override
	public String getKey() {

		return id+"";
	}

	public final Integer getId() {
		return id;
	}

	public final void setId(Integer id) {
		this.id = id;
	}

	public final String getName() {
		return name;
	}

	public final void setName(String name) {
		this.name = name;
	}

	public final Integer getDropNum() {
		return dropNum;
	}

	public final void setDropNum(Integer dropNum) {
		this.dropNum = dropNum;
	}

	public final Integer[] getItemIDs() {
		return itemIDs;
	}

	public final void setItemIDs(Integer[] itemIDs) {
		this.itemIDs = itemIDs;
	}

	public final Integer[] getItemMinNums() {
		return itemMinNums;
	}

	public final void setItemMinNums(Integer[] itemMinNums) {
		this.itemMinNums = itemMinNums;
	}

	public final Integer[] getItemMaxNums() {
		return itemMaxNums;
	}

	public final void setItemMaxNums(Integer[] itemMaxNums) {
		this.itemMaxNums = itemMaxNums;
	}

	public final Integer[] getItemRates() {
		return itemRates;
	}

	public final void setItemRates(Integer[] itemRates) {
		this.itemRates = itemRates;
	}

	public final Integer[] getItemPrice() {
		return itemPrice;
	}

	public final void setItemPrice(Integer[] itemPrice) {
		this.itemPrice = itemPrice;
	}

	public String toString(){
		
		return StringUtils.toString(getClass(), this);
	}
}

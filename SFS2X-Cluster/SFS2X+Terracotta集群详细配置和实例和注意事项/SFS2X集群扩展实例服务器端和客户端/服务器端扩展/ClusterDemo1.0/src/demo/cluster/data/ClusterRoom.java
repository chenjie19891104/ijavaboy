package demo.cluster.data;

import java.util.Map;
import java.util.concurrent.atomic.AtomicInteger;

/**
 * 集群共享的Room对象
 * @author 陈杰
 *
 */
public class ClusterRoom {
	
	private String name;
	private int localId;
	private int gameId;
	private String gameType;
	private int maxPlayers;
	private AtomicInteger playerCount;
	private boolean passwordProtected;
	
	public Map<String, Object> properties;

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getLocalId() {
		return localId;
	}

	public void setLocalId(int localId) {
		this.localId = localId;
	}

	public int getGameId() {
		return gameId;
	}

	public void setGameId(int gameId) {
		this.gameId = gameId;
	}

	public String getGameType() {
		return gameType;
	}

	public void setGameType(String gameType) {
		this.gameType = gameType;
	}

	public int getMaxPlayers() {
		return maxPlayers;
	}

	public void setMaxPlayers(int maxPlayers) {
		this.maxPlayers = maxPlayers;
	}

	public AtomicInteger getPlayerCount() {
		return playerCount;
	}

	public void setPlayerCount(AtomicInteger playerCount) {
		this.playerCount = playerCount;
	}

	public boolean isPasswordProtected() {
		return passwordProtected;
	}

	public void setPasswordProtected(boolean passwordProtected) {
		this.passwordProtected = passwordProtected;
	}

	public Map<String, Object> getProperties() {
		return properties;
	}

	public void setProperties(Map<String, Object> properties) {
		this.properties = properties;
	}
	
	
	

}

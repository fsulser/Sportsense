CREATE EVENT deleteInactiveTasks
    ON SCHEDULE EVERY 20 MINUTE
    DO
      delete from TaskInProgress where started < (NOW() - INTERVAL 30 MINUTE)

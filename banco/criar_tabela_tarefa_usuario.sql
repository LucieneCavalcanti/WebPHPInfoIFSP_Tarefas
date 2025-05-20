-- Tabela de associação entre tarefas e usuários
CREATE TABLE tarefa_usuario (
  id int(11) NOT NULL AUTO_INCREMENT,
  fk_Tarefa_id int(11) NOT NULL,
  fk_Usuario_id int(11) NOT NULL,
  dataSelecao datetime NOT NULL,
  status enum('Em andamento', 'Concluída', 'Cancelada') NOT NULL DEFAULT 'Em andamento',
  observacao text DEFAULT NULL,
  PRIMARY KEY (id),
  KEY FK_tarefa_usuario_1 (fk_Tarefa_id),
  KEY FK_tarefa_usuario_2 (fk_Usuario_id),
  CONSTRAINT FK_tarefa_usuario_1 FOREIGN KEY (fk_Tarefa_id) REFERENCES tarefa (id) ON DELETE CASCADE,
  CONSTRAINT FK_tarefa_usuario_2 FOREIGN KEY (fk_Usuario_id) REFERENCES tbusuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

output "server_ip" {
  description = "Public IP of the server"
  value       = aws_eip.app.public_ip
}

output "ssh_command" {
  description = "Command to log in to the server"
  value       = "ssh ubuntu@${aws_eip.app.public_ip}"
}

output "app_url" {
  description = "Website address"
  value       = "http://${aws_eip.app.public_ip}"
}
